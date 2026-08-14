<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'slug' => 'maternite',
                'name_fr' => 'Maternité',
                'name_en' => 'Maternity',
                'description_fr' => "Suivi de grossesse, accouchement et suivi post-natal, dans un cadre humain et sécurisé.",
                'description_en' => 'Pregnancy monitoring, delivery and postnatal follow-up, in a safe and caring environment.',
                'icon' => 'heart',
                'order' => 1,
            ],
            [
                'slug' => 'kinesitherapie',
                'name_fr' => 'Kinésithérapie',
                'name_en' => 'Physiotherapy',
                'description_fr' => "Rééducation fonctionnelle et soins de kinésithérapie pour tous les âges, sur rendez-vous.",
                'description_en' => 'Functional rehabilitation and physiotherapy care for all ages, by appointment.',
                'icon' => 'activity',
                'order' => 2,
            ],
            [
                'slug' => 'laboratoire',
                'name_fr' => 'Laboratoire',
                'name_en' => 'Laboratory',
                'description_fr' => "Analyses biologiques courantes. Certains examens (ex. glycémie à jeun) nécessitent d'être à jeun — demandez confirmation lors de la prise de rendez-vous.",
                'description_en' => 'Routine lab testing. Some tests (e.g. fasting blood glucose) require fasting — please confirm when booking.',
                'icon' => 'flask',
                'order' => 3,
            ],
            [
                'slug' => 'medecine-generale',
                'name_fr' => 'Médecine générale',
                'name_en' => 'General medicine',
                'description_fr' => "Consultations générales, suivi médical courant et orientation vers les autres services du centre.",
                'description_en' => 'General consultations, routine medical follow-up and referral to the center\'s other services.',
                'icon' => 'stethoscope',
                'order' => 4,
            ],
            [
                'slug' => 'petite-chirurgie',
                'name_fr' => 'Petite chirurgie',
                'name_en' => 'Minor surgery',
                'description_fr' => "Interventions chirurgicales mineures réalisées en ambulatoire, sans hospitalisation.",
                'description_en' => 'Minor surgical procedures performed on an outpatient basis, no hospitalization required.',
                'icon' => 'scissors',
                'order' => 5,
            ],
            [
                'slug' => 'pediatrie',
                'name_fr' => 'Pédiatrie',
                'name_en' => 'Pediatrics',
                'description_fr' => "Suivi de la croissance, vaccination et soins adaptés aux enfants de tout âge.",
                'description_en' => 'Growth monitoring, vaccinations and care adapted to children of all ages.',
                'icon' => 'baby',
                'order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
