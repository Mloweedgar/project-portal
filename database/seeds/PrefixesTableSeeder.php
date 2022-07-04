<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PrefixesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prefixes')->insert([
            'country' => 'Afghanistan',
            'dial_code' => '93',
            'iso' => 'af',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Albania',
            'dial_code' => '355',
            'iso' => 'al',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Algeria',
            'dial_code' => '213',
            'iso' => 'dz',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'American Samoa',
            'dial_code' => '1684',
            'iso' => 'as',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Andorra',
            'dial_code' => '376',
            'iso' => 'ad',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Angola',
            'dial_code' => '244',
            'iso' => 'ao',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Anguilla',
            'dial_code' => '1264',
            'iso' => 'ai',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Antigua &amp; Barbuda',
            'dial_code' => '1268',
            'iso' => 'ag',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Argentina',
            'dial_code' => '54',
            'iso' => 'ar',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Armenia',
            'dial_code' => '374',
            'iso' => 'am',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Aruba',
            'dial_code' => '297',
            'iso' => 'aw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Australia',
            'dial_code' => '61',
            'iso' => 'au',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Austria',
            'dial_code' => '43',
            'iso' => 'at',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Azerbaijan',
            'dial_code' => '994',
            'iso' => 'az',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Bahamas',
            'dial_code' => '1242',
            'iso' => 'bs',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Bahrain',
            'dial_code' => '973',
            'iso' => 'bh',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Bangladesh',
            'dial_code' => '880',
            'iso' => 'bd',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Barbados',
            'dial_code' => '1246',
            'iso' => 'bb',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Belarus',
            'dial_code' => '375',
            'iso' => 'by',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Belgium',
            'dial_code' => '32',
            'iso' => 'be',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Bolivia',
            'dial_code' => '591',
            'iso' => 'bo',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Bosnia &amp; Herzegovina',
            'dial_code' => '387',
            'iso' => 'ba',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Botswana',
            'dial_code' => '267',
            'iso' => 'bw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Brazil',
            'dial_code' => '55',
            'iso' => 'br',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'British Indian Ocean Territory',
            'dial_code' => '246',
            'iso' => 'io',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'British Virgin Islands',
            'dial_code' => '1284',
            'iso' => 'vg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Brunei',
            'dial_code' => '673',
            'iso' => 'bn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Bulgaria',
            'dial_code' => '359',
            'iso' => 'bg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Burkina Faso',
            'dial_code' => '226',
            'iso' => 'bf',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Burundi',
            'dial_code' => '257',
            'iso' => 'bi',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Cambodia',
            'dial_code' => '855',
            'iso' => 'kh',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Cameroon',
            'dial_code' => '237',
            'iso' => 'cm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Canada',
            'dial_code' => '1',
            'iso' => 'ca',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Cape Verde',
            'dial_code' => '238',
            'iso' => 'cv',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Caribbean Netherlands',
            'dial_code' => '599',
            'iso' => 'bq',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Cayman Islands',
            'dial_code' => '1345',
            'iso' => 'ky',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Central African Republic',
            'dial_code' => '236',
            'iso' => 'cf',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Chad',
            'dial_code' => '235',
            'iso' => 'td',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Chile',
            'dial_code' => '56',
            'iso' => 'cl',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'China',
            'dial_code' => '86',
            'iso' => 'cn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Christmas Island',
            'dial_code' => '61',
            'iso' => 'cx',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Cocos (Keeling) Islands',
            'dial_code' => '61',
            'iso' => 'cc',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Colombia',
            'dial_code' => '57',
            'iso' => 'co',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Comoros',
            'dial_code' => '269',
            'iso' => 'km',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Congo - Kinshasa',
            'dial_code' => '243',
            'iso' => 'cd',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Congo - Brazzaville',
            'dial_code' => '242',
            'iso' => 'cg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Cook Islands',
            'dial_code' => '682',
            'iso' => 'ck',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Costa Rica',
            'dial_code' => '506',
            'iso' => 'cr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Côte d’Ivoire',
            'dial_code' => '225',
            'iso' => 'ci',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Croatia',
            'dial_code' => '385',
            'iso' => 'hr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Cuba',
            'dial_code' => '53',
            'iso' => 'cu',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Curaçao',
            'dial_code' => '599',
            'iso' => 'cw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Cyprus',
            'dial_code' => '357',
            'iso' => 'cy',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Czech Republic',
            'dial_code' => '420',
            'iso' => 'cz',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Denmark',
            'dial_code' => '45',
            'iso' => 'dk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Djibouti',
            'dial_code' => '253',
            'iso' => 'dj',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Dominica',
            'dial_code' => '1767',
            'iso' => 'dm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Dominican Republic',
            'dial_code' => '1',
            'iso' => 'do',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Ecuador',
            'dial_code' => '593',
            'iso' => 'ec',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Egypt',
            'dial_code' => '20',
            'iso' => 'eg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'El Salvador',
            'dial_code' => '503',
            'iso' => 'sv',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Equatorial Guinea',
            'dial_code' => '240',
            'iso' => 'gq',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Eritrea',
            'dial_code' => '291',
            'iso' => 'er',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Estonia',
            'dial_code' => '372',
            'iso' => 'ee',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Ethiopia',
            'dial_code' => '251',
            'iso' => 'et',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Falkland Islands',
            'dial_code' => '500',
            'iso' => 'fk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Faroe Islands',
            'dial_code' => '298',
            'iso' => 'fo',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Fiji',
            'dial_code' => '679',
            'iso' => 'fj',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Finland',
            'dial_code' => '358',
            'iso' => 'fi',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'France',
            'dial_code' => '33',
            'iso' => 'fr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'French Guiana',
            'dial_code' => '594',
            'iso' => 'gf',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'French Polynesia',
            'dial_code' => '689',
            'iso' => 'pf',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Gabon',
            'dial_code' => '241',
            'iso' => 'ga',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Gambia',
            'dial_code' => '220',
            'iso' => 'gm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Georgia',
            'dial_code' => '995',
            'iso' => 'ge',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Germany',
            'dial_code' => '49',
            'iso' => 'de',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Ghana',
            'dial_code' => '233',
            'iso' => 'gh',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Gibraltar',
            'dial_code' => '350',
            'iso' => 'gi',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Greece',
            'dial_code' => '30',
            'iso' => 'gr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Greenland',
            'dial_code' => '299',
            'iso' => 'gl',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Grenada',
            'dial_code' => '1473',
            'iso' => 'gd',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Guadeloupe',
            'dial_code' => '590',
            'iso' => 'gp',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Guam',
            'dial_code' => '1671',
            'iso' => 'gu',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Guatemala',
            'dial_code' => '502',
            'iso' => 'gt',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Guernsey',
            'dial_code' => '44',
            'iso' => 'gg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Guinea',
            'dial_code' => '224',
            'iso' => 'gn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Guinea-Bissau',
            'dial_code' => '245',
            'iso' => 'gw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Guyana',
            'dial_code' => '592',
            'iso' => 'gy',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Haiti',
            'dial_code' => '509',
            'iso' => 'ht',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Honduras',
            'dial_code' => '504',
            'iso' => 'hn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Hong Kong SAR China',
            'dial_code' => '852',
            'iso' => 'hk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Hungary',
            'dial_code' => '36',
            'iso' => 'hu',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Iceland',
            'dial_code' => '354',
            'iso' => 'is',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'India',
            'dial_code' => '91',
            'iso' => 'in',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Indonesia',
            'dial_code' => '62',
            'iso' => 'id',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Iran',
            'dial_code' => '98',
            'iso' => 'ir',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Iraq',
            'dial_code' => '964',
            'iso' => 'iq',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Ireland',
            'dial_code' => '353',
            'iso' => 'ie',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Isle of Man',
            'dial_code' => '44',
            'iso' => 'im',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Israel',
            'dial_code' => '972',
            'iso' => 'il',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Italy',
            'dial_code' => '39',
            'iso' => 'it',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Jamaica',
            'dial_code' => '1876',
            'iso' => 'jm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Japan',
            'dial_code' => '81',
            'iso' => 'jp',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Jersey',
            'dial_code' => '44',
            'iso' => 'je',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Jordan',
            'dial_code' => '962',
            'iso' => 'jo',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Kazakhstan',
            'dial_code' => '7',
            'iso' => 'kz',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Kenya',
            'dial_code' => '254',
            'iso' => 'ke',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Kiribati',
            'dial_code' => '686',
            'iso' => 'ki',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Kosovo',
            'dial_code' => '383',
            'iso' => 'xk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Kuwait',
            'dial_code' => '965',
            'iso' => 'kw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Kyrgyzstan',
            'dial_code' => '996',
            'iso' => 'kg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Laos',
            'dial_code' => '856',
            'iso' => 'la',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Latvia',
            'dial_code' => '371',
            'iso' => 'lv',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Lebanon',
            'dial_code' => '961',
            'iso' => 'lb',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Lesotho',
            'dial_code' => '266',
            'iso' => 'ls',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Liberia',
            'dial_code' => '231',
            'iso' => 'lr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Libya',
            'dial_code' => '218',
            'iso' => 'ly',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Liechtenstein',
            'dial_code' => '423',
            'iso' => 'li',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Lithuania',
            'dial_code' => '370',
            'iso' => 'lt',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Luxembourg',
            'dial_code' => '352',
            'iso' => 'lu',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Macau SAR China',
            'dial_code' => '853',
            'iso' => 'mo',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Macedonia',
            'dial_code' => '389',
            'iso' => 'mk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Madagascar',
            'dial_code' => '261',
            'iso' => 'mg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Malawi',
            'dial_code' => '265',
            'iso' => 'mw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Malaysia',
            'dial_code' => '60',
            'iso' => 'my',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Maldives',
            'dial_code' => '960',
            'iso' => 'mv',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Mali',
            'dial_code' => '223',
            'iso' => 'ml',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Malta',
            'dial_code' => '356',
            'iso' => 'mt',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Marshall Islands',
            'dial_code' => '692',
            'iso' => 'mh',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Martinique',
            'dial_code' => '596',
            'iso' => 'mq',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Mauritania',
            'dial_code' => '222',
            'iso' => 'mr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Mauritius',
            'dial_code' => '230',
            'iso' => 'mu',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Mayotte',
            'dial_code' => '262',
            'iso' => 'yt',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Mexico',
            'dial_code' => '52',
            'iso' => 'mx',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Micronesia',
            'dial_code' => '691',
            'iso' => 'fm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Moldova',
            'dial_code' => '373',
            'iso' => 'md',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Monaco',
            'dial_code' => '377',
            'iso' => 'mc',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Mongolia',
            'dial_code' => '976',
            'iso' => 'mn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Montenegro',
            'dial_code' => '382',
            'iso' => 'me',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Montserrat',
            'dial_code' => '1664',
            'iso' => 'ms',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Morocco',
            'dial_code' => '212',
            'iso' => 'ma',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Mozambique',
            'dial_code' => '258',
            'iso' => 'mz',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Myanmar (Burma)',
            'dial_code' => '95',
            'iso' => 'mm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Namibia',
            'dial_code' => '264',
            'iso' => 'na',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Nauru',
            'dial_code' => '674',
            'iso' => 'nr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Nepal',
            'dial_code' => '977',
            'iso' => 'np',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Netherlands',
            'dial_code' => '31',
            'iso' => 'nl',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'New Caledonia',
            'dial_code' => '687',
            'iso' => 'nc',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'New Zealand',
            'dial_code' => '64',
            'iso' => 'nz',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Nicaragua',
            'dial_code' => '505',
            'iso' => 'ni',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Niger',
            'dial_code' => '227',
            'iso' => 'ne',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Nigeria',
            'dial_code' => '234',
            'iso' => 'ng',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Niue',
            'dial_code' => '683',
            'iso' => 'nu',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Norfolk Island',
            'dial_code' => '672',
            'iso' => 'nf',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'North Korea',
            'dial_code' => '850',
            'iso' => 'kp',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Northern Mariana Islands',
            'dial_code' => '1670',
            'iso' => 'mp',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Norway',
            'dial_code' => '47',
            'iso' => 'no',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Oman',
            'dial_code' => '968',
            'iso' => 'om',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Pakistan',
            'dial_code' => '92',
            'iso' => 'pk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Palau',
            'dial_code' => '680',
            'iso' => 'pw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Palestinian Territories',
            'dial_code' => '970',
            'iso' => 'ps',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Panama',
            'dial_code' => '507',
            'iso' => 'pa',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Papua New Guinea',
            'dial_code' => '675',
            'iso' => 'pg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Paraguay',
            'dial_code' => '595',
            'iso' => 'py',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Peru',
            'dial_code' => '51',
            'iso' => 'pe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Philippines',
            'dial_code' => '63',
            'iso' => 'ph',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Poland',
            'dial_code' => '48',
            'iso' => 'pl',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Portugal',
            'dial_code' => '351',
            'iso' => 'pt',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Puerto Rico',
            'dial_code' => '1',
            'iso' => 'pr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Qatar',
            'dial_code' => '974',
            'iso' => 'qa',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Réunion',
            'dial_code' => '262',
            'iso' => 're',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Romania',
            'dial_code' => '40',
            'iso' => 'ro',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Russia',
            'dial_code' => '7',
            'iso' => 'ru',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Rwanda',
            'dial_code' => '250',
            'iso' => 'rw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'St. Barthélemy',
            'dial_code' => '590',
            'iso' => 'bl',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'St. Helena',
            'dial_code' => '290',
            'iso' => 'sh',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'St. Kitts &amp; Nevis',
            'dial_code' => '1869',
            'iso' => 'kn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'St. Lucia',
            'dial_code' => '1758',
            'iso' => 'lc',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'St. Martin',
            'dial_code' => '590',
            'iso' => 'mf',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'St. Pierre &amp; Miquelon',
            'dial_code' => '508',
            'iso' => 'pm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'St. Vincent &amp; Grenadines',
            'dial_code' => '1784',
            'iso' => 'vc',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Samoa',
            'dial_code' => '685',
            'iso' => 'ws',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'San Marino',
            'dial_code' => '378',
            'iso' => 'sm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'São Tomé &amp; Príncipe',
            'dial_code' => '239',
            'iso' => 'st',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Saudi Arabia',
            'dial_code' => '966',
            'iso' => 'sa',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Senegal',
            'dial_code' => '221',
            'iso' => 'sn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Serbia',
            'dial_code' => '381',
            'iso' => 'rs',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Seychelles',
            'dial_code' => '248',
            'iso' => 'sc',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Sierra Leone',
            'dial_code' => '232',
            'iso' => 'sl',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Singapore',
            'dial_code' => '65',
            'iso' => 'sg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Sint Maarten',
            'dial_code' => '1721',
            'iso' => 'sx',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Slovakia',
            'dial_code' => '421',
            'iso' => 'sk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Slovenia',
            'dial_code' => '386',
            'iso' => 'si',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Solomon Islands',
            'dial_code' => '677',
            'iso' => 'sb',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Somalia',
            'dial_code' => '252',
            'iso' => 'so',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'South Africa',
            'dial_code' => '27',
            'iso' => 'za',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'South Korea',
            'dial_code' => '82',
            'iso' => 'kr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'South Sudan',
            'dial_code' => '211',
            'iso' => 'ss',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Spain',
            'dial_code' => '34',
            'iso' => 'es',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Sri Lanka',
            'dial_code' => '94',
            'iso' => 'lk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Sudan',
            'dial_code' => '249',
            'iso' => 'sd',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Suriname',
            'dial_code' => '597',
            'iso' => 'sr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Svalbard &amp; Jan Mayen',
            'dial_code' => '47',
            'iso' => 'sj',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Swaziland',
            'dial_code' => '268',
            'iso' => 'sz',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Sweden',
            'dial_code' => '46',
            'iso' => 'se',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Switzerland',
            'dial_code' => '41',
            'iso' => 'ch',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Syria',
            'dial_code' => '963',
            'iso' => 'sy',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Taiwan',
            'dial_code' => '886',
            'iso' => 'tw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Tajikistan',
            'dial_code' => '992',
            'iso' => 'tj',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Tanzania',
            'dial_code' => '255',
            'iso' => 'tz',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Thailand',
            'dial_code' => '66',
            'iso' => 'th',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Timor-Leste',
            'dial_code' => '670',
            'iso' => 'tl',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Togo',
            'dial_code' => '228',
            'iso' => 'tg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Tokelau',
            'dial_code' => '690',
            'iso' => 'tk',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Tonga',
            'dial_code' => '676',
            'iso' => 'to',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Trinidad &amp; Tobago',
            'dial_code' => '1868',
            'iso' => 'tt',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Tunisia',
            'dial_code' => '216',
            'iso' => 'tn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Turkey',
            'dial_code' => '90',
            'iso' => 'tr',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Turkmenistan',
            'dial_code' => '993',
            'iso' => 'tm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Turks &amp; Caicos Islands',
            'dial_code' => '1649',
            'iso' => 'tc',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Tuvalu',
            'dial_code' => '688',
            'iso' => 'tv',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'U.S. Virgin Islands',
            'dial_code' => '1340',
            'iso' => 'vi',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Uganda',
            'dial_code' => '256',
            'iso' => 'ug',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Ukraine',
            'dial_code' => '380',
            'iso' => 'ua',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'United Arab Emirates',
            'dial_code' => '971',
            'iso' => 'ae',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'United Kingdom',
            'dial_code' => '44',
            'iso' => 'gb',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'United States',
            'dial_code' => '1',
            'iso' => 'us',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Uruguay',
            'dial_code' => '598',
            'iso' => 'uy',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Uzbekistan',
            'dial_code' => '998',
            'iso' => 'uz',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Vanuatu',
            'dial_code' => '678',
            'iso' => 'vu',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Vatican City',
            'dial_code' => '39',
            'iso' => 'va',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Venezuela',
            'dial_code' => '58',
            'iso' => 've',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Vietnam',
            'dial_code' => '84',
            'iso' => 'vn',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Wallis &amp; Futuna',
            'dial_code' => '681',
            'iso' => 'wf',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Western Sahara',
            'dial_code' => '212',
            'iso' => 'eh',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Yemen',
            'dial_code' => '967',
            'iso' => 'ye',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Zambia',
            'dial_code' => '260',
            'iso' => 'zm',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Zimbabwe',
            'dial_code' => '263',
            'iso' => 'zw',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('prefixes')->insert([
            'country' => 'Åland Islands',
            'dial_code' => '358',
            'iso' => 'ax',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);



    }
}
