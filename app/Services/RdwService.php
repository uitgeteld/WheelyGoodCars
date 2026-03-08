<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class RdwService
{
    private const RDW_URL = 'https://opendata.rdw.nl/resource/m9d7-ebf2.json';
    private const CACHE = 3600;

    /**
     * Get vehicle data by license plate
     * 
     * @throws ConnectionException if unable to connect to RDW API
     */
    public static function getByPlate(string $plate): ?array
    {
        $plate = strtoupper(preg_replace('/[^A-Z0-9]/', '', $plate));

        return Cache::remember("rdw_plate_{$plate}", self::CACHE, function () use ($plate) {
            $response = Http::withOptions(['verify' => false])
                ->timeout(10)
                ->get(self::RDW_URL, ['kenteken' => $plate]);

            if ($response->successful() && !empty($response->json())) {
                return self::mapVehicle($response->json()[0]);
            }

            return null;
        });
    }

    public static function getVehicles(int $limit = 250, int $offset = 0): array
    {
        return Cache::remember("rdw_vehicles_{$limit}_{$offset}", self::CACHE, function () use ($limit, $offset) {
            try {
                $response = Http::withOptions(['verify' => false])
                    ->timeout(10)
                    ->get(self::RDW_URL, [
                        '$limit'  => $limit,
                        '$offset' => $offset,
                        '$order'  => 'kenteken ASC',
                    ]);

                if ($response->successful())
                    return array_map(fn($v) => self::mapVehicle($v), $response->json() ?? []);
            } catch (\Exception $e) {
                logger()->warning('RDW API error: ' . $e->getMessage());
            }
            return [];
        });
    }

    private static function mapVehicle(array $v): array
    {
        $year = null;
        $firstReg = $v['datum_eerste_toelating'] ?? $v['eerste_afgifte'] ?? null;
        if ($firstReg) {
            $ts = strtotime($firstReg);
            $year = $ts !== false ? (int)date('Y', $ts) : null;
        }
        if (!$year && isset($v['bouwjaar']))
            $year = (int)$v['bouwjaar'];

        $colorRaw = $v['eerste_kleur'] ?? $v['kleur'] ?? null;
        $color = $colorRaw
            ? trim(preg_replace('/\bmetallic\b/i', '', explode(',', $colorRaw)[0]))
            : null;

        $powerKw = null;
        if (!empty($v['vermogen_kw']))
            $powerKw = (int)preg_replace('/[^0-9]/', '', $v['vermogen_kw']);
        elseif (!empty($v['vermogen_pk']))
            $powerKw = (int)round((int)preg_replace('/[^0-9]/', '', $v['vermogen_pk']) * 0.7355);

        $apkExpiry = null;
        if (!empty($v['vervaldatum_apk'])) {
            $apkDate = $v['vervaldatum_apk'];
            if (strlen($apkDate) === 8) {
                $apkExpiry = substr($apkDate, 0, 4) . '-' . substr($apkDate, 4, 2) . '-' . substr($apkDate, 6, 2);
            }
        }

        return [
            'license_plate'      => $v['kenteken']               ?? null,
            'make'               => $v['merk']                   ?? null,
            'model'              => $v['handelsbenaming']         ?? $v['type'] ?? null,
            'variant'            => $v['uitvoering']              ?? null,
            'body_type'          => $v['voertuigsoort'] ?? null,
            'body_style'         => $v['inrichting'] ?? null, // sedan, hatchback, etc.
            'fuel_type'          => $v['brandstof_omschrijving']  ?? null,
            'transmission'       => $v['transmissie']             ?? null,
            'production_year'    => $year,
            'first_registration' => $firstReg && strtotime($firstReg)
                ? date('Y-m-d', strtotime($firstReg))
                : null,
            'apk_expiry'         => $apkExpiry,
            'seats'              => isset($v['aantal_zitplaatsen']) ? (int)$v['aantal_zitplaatsen'] : null,
            'doors'              => isset($v['aantal_deuren'])      ? (int)$v['aantal_deuren']      : null,
            'cylinders'          => isset($v['aantal_cilinders'])   ? (int)$v['aantal_cilinders']   : null,
            'engine_capacity'    => isset($v['cilinderinhoud'])     ? (int)$v['cilinderinhoud']     : null, // cc
            'color'              => $color,
            'color_secondary'    => $v['tweede_kleur'] ?? null,
            'weight'             => isset($v['massa_rijklaar'])     ? (int)$v['massa_rijklaar']     : null,
            'power_kw'           => $powerKw,
            'co2'                => isset($v['co2_uitstoot'])       ? (int)$v['co2_uitstoot']       : null,
            'catalog_price'      => isset($v['catalogusprijs'])     ? (int)$v['catalogusprijs']     : null,
            'vehicle_category'   => $v['europese_voertuigcategorie'] ?? null,
            'vin'                => isset($v['chassisnummer'])
                ? strtoupper(preg_replace('/\s+/', '', $v['chassisnummer']))
                : null,
        ];
    }
}
