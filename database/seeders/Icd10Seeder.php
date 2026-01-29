<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Icd10;
use Illuminate\Support\Facades\DB;

class Icd10Seeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks untuk mempercepat seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Icd10::truncate();

        $data = [
            // A00-B99 Certain infectious and parasitic diseases
            ['code' => 'A00', 'name_en' => 'Cholera', 'name_id' => 'Kolera'],
            ['code' => 'A01.0', 'name_en' => 'Typhoid fever', 'name_id' => 'Demam Tifoid (Tipes)'],
            ['code' => 'A09', 'name_en' => 'Infectious gastroenteritis and colitis, unspecified', 'name_id' => 'Diare & Gastroenteritis (Muntaber)'],
            ['code' => 'A15.0', 'name_en' => 'Tuberculosis of lung, confirmed by sputum microscopy', 'name_id' => 'Tuberkulosis (TBC) Paru'],
            ['code' => 'A90', 'name_en' => 'Dengue fever [classical dengue]', 'name_id' => 'Demam Dengue (DD)'],
            ['code' => 'A91', 'name_en' => 'Dengue haemorrhagic fever', 'name_id' => 'Demam Berdarah Dengue (DBD)'],
            ['code' => 'B05', 'name_en' => 'Measles', 'name_id' => 'Campak (Morbili)'],
            ['code' => 'B15', 'name_en' => 'Acute hepatitis A', 'name_id' => 'Hepatitis A Akut'],
            ['code' => 'B16', 'name_en' => 'Acute hepatitis B', 'name_id' => 'Hepatitis B Akut'],
            ['code' => 'B20', 'name_en' => 'Human immunodeficiency virus [HIV] disease', 'name_id' => 'Penyakit HIV'],

            // C00-D48 Neoplasms
            ['code' => 'C50', 'name_en' => 'Malignant neoplasm of breast', 'name_id' => 'Kanker Payudara'],
            ['code' => 'C53', 'name_en' => 'Malignant neoplasm of cervix uteri', 'name_id' => 'Kanker Serviks'],
            ['code' => 'D50', 'name_en' => 'Iron deficiency anaemia', 'name_id' => 'Anemia Defisiensi Besi'],

            // E00-E90 Endocrine, nutritional and metabolic diseases
            ['code' => 'E10', 'name_en' => 'Type 1 diabetes mellitus', 'name_id' => 'Diabetes Melitus Tipe 1'],
            ['code' => 'E11', 'name_en' => 'Type 2 diabetes mellitus', 'name_id' => 'Diabetes Melitus Tipe 2 (Kencing Manis)'],
            ['code' => 'E11.9', 'name_en' => 'Type 2 diabetes mellitus without complications', 'name_id' => 'Diabetes Melitus Tipe 2 Tanpa Komplikasi'],
            ['code' => 'E66', 'name_en' => 'Obesity', 'name_id' => 'Obesitas'],
            ['code' => 'E78.0', 'name_en' => 'Pure hypercholesterolaemia', 'name_id' => 'Kolesterol Tinggi (Hiperkolesterolemia)'],
            ['code' => 'E79.0', 'name_en' => 'Hyperuricaemia without signs of inflammatory arthritis and tophaceous disease', 'name_id' => 'Asam Urat Tinggi (Hiperurisemia)'],

            // F00-F99 Mental and behavioural disorders
            ['code' => 'F20', 'name_en' => 'Schizophrenia', 'name_id' => 'Skizofrenia'],
            ['code' => 'F32', 'name_en' => 'Depressive episode', 'name_id' => 'Depresi'],
            ['code' => 'F41.9', 'name_en' => 'Anxiety disorder, unspecified', 'name_id' => 'Gangguan Kecemasan (Anxiety)'],

            // G00-G99 Diseases of the nervous system
            ['code' => 'G40', 'name_en' => 'Epilepsy', 'name_id' => 'Epilepsi (Ayan)'],
            ['code' => 'G43', 'name_en' => 'Migraine', 'name_id' => 'Migrain (Sakit Kepala Sebelah)'],
            ['code' => 'G44.2', 'name_en' => 'Tension-type headache', 'name_id' => 'Sakit Kepala Tegang (Tension Headache)'],

            // H00-H59 Diseases of the eye and adnexa
            ['code' => 'H10', 'name_en' => 'Conjunctivitis', 'name_id' => 'Konjungtivitis (Mata Merah)'],
            ['code' => 'H25', 'name_en' => 'Senile cataract', 'name_id' => 'Katarak'],
            ['code' => 'H52.1', 'name_en' => 'Myopia', 'name_id' => 'Rabun Jauh (Miopi)'],

            // H60-H95 Diseases of the ear and mastoid process
            ['code' => 'H60', 'name_en' => 'Otitis externa', 'name_id' => 'Otitis Eksterna (Infeksi Telinga Luar)'],
            ['code' => 'H66', 'name_en' => 'Suppurative and unspecified otitis media', 'name_id' => 'Otitis Media (Infeksi Telinga Tengah)'],

            // I00-I99 Diseases of the circulatory system
            ['code' => 'I10', 'name_en' => 'Essential (primary) hypertension', 'name_id' => 'Hipertensi (Darah Tinggi)'],
            ['code' => 'I20', 'name_en' => 'Angina pectoris', 'name_id' => 'Angina Pektoris (Nyeri Dada Jantung)'],
            ['code' => 'I21', 'name_en' => 'Acute myocardial infarction', 'name_id' => 'Serangan Jantung Akut'],
            ['code' => 'I50', 'name_en' => 'Heart failure', 'name_id' => 'Gagal Jantung'],
            ['code' => 'I64', 'name_en' => 'Stroke, not specified as haemorrhage or infarction', 'name_id' => 'Stroke'],

            // J00-J99 Diseases of the respiratory system
            ['code' => 'J00', 'name_en' => 'Acute nasopharyngitis [common cold]', 'name_id' => 'Common Cold (Pilek/Selesma)'],
            ['code' => 'J01', 'name_en' => 'Acute sinusitis', 'name_id' => 'Sinusitis Akut'],
            ['code' => 'J02', 'name_en' => 'Acute pharyngitis', 'name_id' => 'Faringitis Akut (Radang Tenggorokan)'],
            ['code' => 'J03', 'name_en' => 'Acute tonsillitis', 'name_id' => 'Tonsilitis Akut (Radang Amandel)'],
            ['code' => 'J06.9', 'name_en' => 'Acute upper respiratory infection, unspecified', 'name_id' => 'ISPA (Infeksi Saluran Pernapasan Akut)'],
            ['code' => 'J18', 'name_en' => 'Pneumonia, organism unspecified', 'name_id' => 'Pneumonia (Radang Paru)'],
            ['code' => 'J20', 'name_en' => 'Acute bronchitis', 'name_id' => 'Bronkitis Akut'],
            ['code' => 'J45', 'name_en' => 'Asthma', 'name_id' => 'Asma'],

            // K00-K93 Diseases of the digestive system
            ['code' => 'K02', 'name_en' => 'Dental caries', 'name_id' => 'Karies Gigi (Gigi Berlubang)'],
            ['code' => 'K04', 'name_en' => 'Diseases of pulp and periapical tissues', 'name_id' => 'Sakit Gigi (Pulpitis)'],
            ['code' => 'K21', 'name_en' => 'Gastro-oesophageal reflux disease', 'name_id' => 'GERD (Asam Lambung)'],
            ['code' => 'K29.7', 'name_en' => 'Gastritis, unspecified', 'name_id' => 'Gastritis (Maag)'],
            ['code' => 'K30', 'name_en' => 'Dyspepsia', 'name_id' => 'Dispepsia (Gangguan Pencernaan)'],
            ['code' => 'K35', 'name_en' => 'Acute appendicitis', 'name_id' => 'Usus Buntu Akut'],

            // L00-L99 Diseases of the skin and subcutaneous tissue
            ['code' => 'L01', 'name_en' => 'Impetigo', 'name_id' => 'Impetigo (Infeksi Kulit Bakteri)'],
            ['code' => 'L02', 'name_en' => 'Cutaneous abscess, furuncle and carbuncle', 'name_id' => 'Bisul (Abses Kulit)'],
            ['code' => 'L20', 'name_en' => 'Atopic dermatitis', 'name_id' => 'Dermatitis Atopik (Eksim)'],
            ['code' => 'L23', 'name_en' => 'Allergic contact dermatitis', 'name_id' => 'Alergi Kulit Kontak'],
            ['code' => 'L50', 'name_en' => 'Urticaria', 'name_id' => 'Biduran (Urtikaria)'],

            // M00-M99 Diseases of the musculoskeletal system
            ['code' => 'M06', 'name_en' => 'Rheumatoid arthritis', 'name_id' => 'Rematik (Rheumatoid Arthritis)'],
            ['code' => 'M10', 'name_en' => 'Gout', 'name_id' => 'Penyakit Asam Urat (Gout)'],
            ['code' => 'M54.5', 'name_en' => 'Low back pain', 'name_id' => 'Nyeri Punggung Bawah (Low Back Pain)'],
            ['code' => 'M79.1', 'name_en' => 'Myalgia', 'name_id' => 'Nyeri Otot (Myalgia)'],

            // N00-N99 Diseases of the genitourinary system
            ['code' => 'N17', 'name_en' => 'Acute kidney failure', 'name_id' => 'Gagal Ginjal Akut'],
            ['code' => 'N18', 'name_en' => 'Chronic kidney disease', 'name_id' => 'Gagal Ginjal Kronis'],
            ['code' => 'N39.0', 'name_en' => 'Urinary tract infection, site not specified', 'name_id' => 'Infeksi Saluran Kemih (ISK)'],

            // O00-O99 Pregnancy, childbirth and the puerperium
            ['code' => 'O80', 'name_en' => 'Single spontaneous delivery', 'name_id' => 'Persalinan Normal Spontan'],

            // R00-R99 Symptoms, signs and abnormal clinical and laboratory findings
            ['code' => 'R05', 'name_en' => 'Cough', 'name_id' => 'Batuk'],
            ['code' => 'R10', 'name_en' => 'Abdominal and pelvic pain', 'name_id' => 'Nyeri Perut'],
            ['code' => 'R50', 'name_en' => 'Fever of other and unknown origin', 'name_id' => 'Demam (Febris)'],
            ['code' => 'R51', 'name_en' => 'Headache', 'name_id' => 'Sakit Kepala'],

            // S00-T98 Injury, poisoning and certain other consequences of external causes
            ['code' => 'S00', 'name_en' => 'Superficial injury of head', 'name_id' => 'Cedera Ringan Kepala'],
            ['code' => 'T14', 'name_en' => 'Injury of unspecified body region', 'name_id' => 'Luka/Cedera Umum'],
        ];

        // Insert Batch
        $chunks = array_chunk($data, 50);
        foreach ($chunks as $chunk) {
            Icd10::insert($chunk);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}