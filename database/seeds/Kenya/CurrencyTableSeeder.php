<?php

namespace Kenya;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('currencies')->insert(['name'=>'Afghani','iso'=>'AFN']); DB::table('currencies')->insert(['name'=>'Euro','iso'=>'EUR']); DB::table('currencies')->insert(['name'=>'Lek','iso'=>'ALL']); DB::table('currencies')->insert(['name'=>'Algerian Dinar','iso'=>'DZD']); DB::table('currencies')->insert(['name'=>'US Dollar','iso'=>'USD']); DB::table('currencies')->insert(['name'=>'Kwanza','iso'=>'AOA']); DB::table('currencies')->insert(['name'=>'East Caribbean Dollar','iso'=>'XCD']);DB::table('currencies')->insert(['name'=>'Argentine Peso','iso'=>'ARS']);DB::table('currencies')->insert(['name'=>'Armenian Dram','iso'=>'AMD']);DB::table('currencies')->insert(['name'=>'Aruban Florin','iso'=>'AWG']);DB::table('currencies')->insert(['name'=>'Azerbaijan Manat','iso'=>'AZN']);DB::table('currencies')->insert(['name'=>'Bahamian Dollar','iso'=>'BSD']);DB::table('currencies')->insert(['name'=>'Bahraini Dinar','iso'=>'BHD']);DB::table('currencies')->insert(['name'=>'Taka','iso'=>'BDT']);DB::table('currencies')->insert(['name'=>'Barbados Dollar','iso'=>'BBD']);DB::table('currencies')->insert(['name'=>'Belarusian Ruble','iso'=>'BYN']);DB::table('currencies')->insert(['name'=>'Belize Dollar','iso'=>'BZD']);DB::table('currencies')->insert(['name'=>'CFA Franc BCEAO','iso'=>'XOF']);DB::table('currencies')->insert(['name'=>'Bermudian Dollar','iso'=>'BMD']);DB::table('currencies')->insert(['name'=>'Ngultrum','iso'=>'BTN']);DB::table('currencies')->insert(['name'=>'Boliviano','iso'=>'BOB']);DB::table('currencies')->insert(['name'=>'Mvdol','iso'=>'BOV']);DB::table('currencies')->insert(['name'=>'Convertible Mark','iso'=>'BAM']);DB::table('currencies')->insert(['name'=>'Pula','iso'=>'BWP']);DB::table('currencies')->insert(['name'=>'Brazilian Real','iso'=>'BRL']);DB::table('currencies')->insert(['name'=>'Brunei Dollar','iso'=>'BND']);DB::table('currencies')->insert(['name'=>'Bulgarian Lev','iso'=>'BGN']);DB::table('currencies')->insert(['name'=>'Burundi Franc','iso'=>'BIF']);DB::table('currencies')->insert(['name'=>'Cabo Verde Escudo','iso'=>'CVE']);DB::table('currencies')->insert(['name'=>'Riel','iso'=>'KHR']);DB::table('currencies')->insert(['name'=>'CFA Franc BEAC','iso'=>'XAF']);DB::table('currencies')->insert(['name'=>'Canadian Dollar','iso'=>'CAD']);DB::table('currencies')->insert(['name'=>'Cayman Islands Dollar','iso'=>'KYD']);DB::table('currencies')->insert(['name'=>'Chilean Peso','iso'=>'CLP']);DB::table('currencies')->insert(['name'=>'Unidad de Fomento','iso'=>'CLF']);DB::table('currencies')->insert(['name'=>'Yuan Renminbi','iso'=>'CNY']);DB::table('currencies')->insert(['name'=>'Colombian Peso','iso'=>'COP']);DB::table('currencies')->insert(['name'=>'Unidad de Valor Real','iso'=>'COU']);DB::table('currencies')->insert(['name'=>'Comorian Franc','iso'=>'KMF']);DB::table('currencies')->insert(['name'=>'Congolese Franc','iso'=>'CDF']);DB::table('currencies')->insert(['name'=>'New Zealand Dollar','iso'=>'NZD']);DB::table('currencies')->insert(['name'=>'Costa Rican Colon','iso'=>'CRC']);DB::table('currencies')->insert(['name'=>'Kuna','iso'=>'HRK']);DB::table('currencies')->insert(['name'=>'Cuban Peso','iso'=>'CUP']);DB::table('currencies')->insert(['name'=>'Peso Convertible','iso'=>'CUC']);DB::table('currencies')->insert(['name'=>'Netherlands Antillean Guilder','iso'=>'ANG']);DB::table('currencies')->insert(['name'=>'Czech Koruna','iso'=>'CZK']);DB::table('currencies')->insert(['name'=>'Djibouti Franc','iso'=>'DJF']);DB::table('currencies')->insert(['name'=>'Dominican Peso','iso'=>'DOP']);DB::table('currencies')->insert(['name'=>'Egyptian Pound','iso'=>'EGP']);DB::table('currencies')->insert(['name'=>'El Salvador Colon','iso'=>'SVC']);DB::table('currencies')->insert(['name'=>'Nakfa','iso'=>'ERN']);DB::table('currencies')->insert(['name'=>'Ethiopian Birr','iso'=>'ETB']);DB::table('currencies')->insert(['name'=>'Falkland Islands Pound','iso'=>'FKP']);DB::table('currencies')->insert(['name'=>'Fiji Dollar','iso'=>'FJD']);DB::table('currencies')->insert(['name'=>'Dalasi','iso'=>'GMD']);DB::table('currencies')->insert(['name'=>'Lari','iso'=>'GEL']);DB::table('currencies')->insert(['name'=>'Ghana Cedi','iso'=>'GHS']);DB::table('currencies')->insert(['name'=>'Gibraltar Pound','iso'=>'GIP']);DB::table('currencies')->insert(['name'=>'Danish Krone','iso'=>'DKK']);DB::table('currencies')->insert(['name'=>'Quetzal','iso'=>'GTQ']);DB::table('currencies')->insert(['name'=>'Guinean Franc','iso'=>'GNF']);DB::table('currencies')->insert(['name'=>'Guyana Dollar','iso'=>'GYD']);DB::table('currencies')->insert(['name'=>'Gourde','iso'=>'HTG']);DB::table('currencies')->insert(['name'=>'Lempira','iso'=>'HNL']);DB::table('currencies')->insert(['name'=>'Hong Kong Dollar','iso'=>'HKD']);DB::table('currencies')->insert(['name'=>'Forint','iso'=>'HUF']);DB::table('currencies')->insert(['name'=>'Iceland Krona','iso'=>'ISK']);DB::table('currencies')->insert(['name'=>'Indian Rupee','iso'=>'INR']);DB::table('currencies')->insert(['name'=>'Rupiah','iso'=>'IDR']);DB::table('currencies')->insert(['name'=>'SDR (Special Drawing Right)','iso'=>'XDR']);DB::table('currencies')->insert(['name'=>'Iranian Rial','iso'=>'IRR']);DB::table('currencies')->insert(['name'=>'Iraqi Dinar','iso'=>'IQD']);DB::table('currencies')->insert(['name'=>'New Israeli Sheqel','iso'=>'ILS']);DB::table('currencies')->insert(['name'=>'Jamaican Dollar','iso'=>'JMD']);DB::table('currencies')->insert(['name'=>'Yen','iso'=>'JPY']);DB::table('currencies')->insert(['name'=>'Pound Sterling','iso'=>'GBP']);DB::table('currencies')->insert(['name'=>'Jordanian Dinar','iso'=>'JOD']);DB::table('currencies')->insert(['name'=>'Tenge','iso'=>'KZT']);DB::table('currencies')->insert(['name'=>'Kenyan Shilling','iso'=>'KES']);DB::table('currencies')->insert(['name'=>'Australian Dollar','iso'=>'AUD']);DB::table('currencies')->insert(['name'=>'North Korean Won','iso'=>'KPW']);DB::table('currencies')->insert(['name'=>'Won','iso'=>'KRW']);DB::table('currencies')->insert(['name'=>'Kuwaiti Dinar','iso'=>'KWD']);DB::table('currencies')->insert(['name'=>'Som','iso'=>'KGS']);DB::table('currencies')->insert(['name'=>'Lao Kip','iso'=>'LAK']);DB::table('currencies')->insert(['name'=>'Lebanese Pound','iso'=>'LBP']);DB::table('currencies')->insert(['name'=>'Loti','iso'=>'LSL']);DB::table('currencies')->insert(['name'=>'Rand','iso'=>'ZAR']);DB::table('currencies')->insert(['name'=>'Liberian Dollar','iso'=>'LRD']);DB::table('currencies')->insert(['name'=>'Libyan Dinar','iso'=>'LYD']);DB::table('currencies')->insert(['name'=>'Pataca','iso'=>'MOP']);DB::table('currencies')->insert(['name'=>'Denar','iso'=>'MKD']);DB::table('currencies')->insert(['name'=>'Malagasy Ariary','iso'=>'MGA']);DB::table('currencies')->insert(['name'=>'Malawi Kwacha','iso'=>'MWK']);DB::table('currencies')->insert(['name'=>'Malaysian Ringgit','iso'=>'MYR']);DB::table('currencies')->insert(['name'=>'Rufiyaa','iso'=>'MVR']);DB::table('currencies')->insert(['name'=>'Ouguiya','iso'=>'MRO']);DB::table('currencies')->insert(['name'=>'Mauritius Rupee','iso'=>'MUR']);DB::table('currencies')->insert(['name'=>'ADB Unit of Account','iso'=>'XUA']);DB::table('currencies')->insert(['name'=>'Mexican Peso','iso'=>'MXN']);DB::table('currencies')->insert(['name'=>'Mexican Unidad de Inversion (UDI)','iso'=>'MXV']);DB::table('currencies')->insert(['name'=>'Moldovan Leu','iso'=>'MDL']);DB::table('currencies')->insert(['name'=>'Tugrik','iso'=>'MNT']);DB::table('currencies')->insert(['name'=>'Mozambique Metical','iso'=>'MZN']);DB::table('currencies')->insert(['name'=>'Kyat','iso'=>'MMK']);DB::table('currencies')->insert(['name'=>'Namibia Dollar','iso'=>'NAD']);DB::table('currencies')->insert(['name'=>'Nepalese Rupee','iso'=>'NPR']);DB::table('currencies')->insert(['name'=>'CFP Franc','iso'=>'XPF']);DB::table('currencies')->insert(['name'=>'Cordoba Oro','iso'=>'NIO']);DB::table('currencies')->insert(['name'=>'Naira','iso'=>'NGN']);DB::table('currencies')->insert(['name'=>'Rial Omani','iso'=>'OMR']);DB::table('currencies')->insert(['name'=>'Pakistan Rupee','iso'=>'PKR']);DB::table('currencies')->insert(['name'=>'Balboa','iso'=>'PAB']);DB::table('currencies')->insert(['name'=>'Kina','iso'=>'PGK']);DB::table('currencies')->insert(['name'=>'Guarani','iso'=>'PYG']);DB::table('currencies')->insert(['name'=>'Sol','iso'=>'PEN']);DB::table('currencies')->insert(['name'=>'Philippine Peso','iso'=>'PHP']);DB::table('currencies')->insert(['name'=>'Zloty','iso'=>'PLN']);DB::table('currencies')->insert(['name'=>'Qatari Rial','iso'=>'QAR']);DB::table('currencies')->insert(['name'=>'Romanian Leu','iso'=>'RON']);DB::table('currencies')->insert(['name'=>'Russian Ruble','iso'=>'RUB']);DB::table('currencies')->insert(['name'=>'Rwanda Franc','iso'=>'RWF']);DB::table('currencies')->insert(['name'=>'Saint Helena Pound','iso'=>'SHP']);DB::table('currencies')->insert(['name'=>'Tala','iso'=>'WST']);DB::table('currencies')->insert(['name'=>'Dobra','iso'=>'STD']);DB::table('currencies')->insert(['name'=>'Saudi Riyal','iso'=>'SAR']);DB::table('currencies')->insert(['name'=>'Serbian Dinar','iso'=>'RSD']);DB::table('currencies')->insert(['name'=>'Seychelles Rupee','iso'=>'SCR']);DB::table('currencies')->insert(['name'=>'Leone','iso'=>'SLL']);DB::table('currencies')->insert(['name'=>'Singapore Dollar','iso'=>'SGD']);DB::table('currencies')->insert(['name'=>'Sucre','iso'=>'XSU']);DB::table('currencies')->insert(['name'=>'Solomon Islands Dollar','iso'=>'SBD']);DB::table('currencies')->insert(['name'=>'Somali Shilling','iso'=>'SOS']);DB::table('currencies')->insert(['name'=>'South Sudanese Pound','iso'=>'SSP']);DB::table('currencies')->insert(['name'=>'Sri Lanka Rupee','iso'=>'LKR']);DB::table('currencies')->insert(['name'=>'Sudanese Pound','iso'=>'SDG']);DB::table('currencies')->insert(['name'=>'Surinam Dollar','iso'=>'SRD']);DB::table('currencies')->insert(['name'=>'Norwegian Krone','iso'=>'NOK']);DB::table('currencies')->insert(['name'=>'Lilangeni','iso'=>'SZL']);DB::table('currencies')->insert(['name'=>'Swedish Krona','iso'=>'SEK']);DB::table('currencies')->insert(['name'=>'Swiss Franc','iso'=>'CHF']);DB::table('currencies')->insert(['name'=>'WIR Euro','iso'=>'CHE']);DB::table('currencies')->insert(['name'=>'WIR Franc','iso'=>'CHW']);DB::table('currencies')->insert(['name'=>'Syrian Pound','iso'=>'SYP']);DB::table('currencies')->insert(['name'=>'New Taiwan Dollar','iso'=>'TWD']);DB::table('currencies')->insert(['name'=>'Somoni','iso'=>'TJS']);DB::table('currencies')->insert(['name'=>'Tanzanian Shilling','iso'=>'TZS']);DB::table('currencies')->insert(['name'=>'Baht','iso'=>'THB']);DB::table('currencies')->insert(['name'=>'Pa’anga','iso'=>'TOP']);DB::table('currencies')->insert(['name'=>'Trinidad and Tobago Dollar','iso'=>'TTD']);DB::table('currencies')->insert(['name'=>'Tunisian Dinar','iso'=>'TND']);DB::table('currencies')->insert(['name'=>'Turkish Lira','iso'=>'TRY']);DB::table('currencies')->insert(['name'=>'Turkmenistan New Manat','iso'=>'TMT']);DB::table('currencies')->insert(['name'=>'Uganda Shilling','iso'=>'UGX']);DB::table('currencies')->insert(['name'=>'Hryvnia','iso'=>'UAH']);DB::table('currencies')->insert(['name'=>'UAE Dirham','iso'=>'AED']);DB::table('currencies')->insert(['name'=>'US Dollar (Next day)','iso'=>'USN']);DB::table('currencies')->insert(['name'=>'Peso Uruguayo','iso'=>'UYU']);DB::table('currencies')->insert(['name'=>'Uruguay Peso en Unidades Indexadas (URUIURUI)','iso'=>'UYI']);DB::table('currencies')->insert(['name'=>'Uzbekistan Sum','iso'=>'UZS']);DB::table('currencies')->insert(['name'=>'Vatu','iso'=>'VUV']);DB::table('currencies')->insert(['name'=>'Bolívar','iso'=>'VEF']);DB::table('currencies')->insert(['name'=>'Dong','iso'=>'VND']);DB::table('currencies')->insert(['name'=>'Moroccan Dirham','iso'=>'MAD']);DB::table('currencies')->insert(['name'=>'Yemeni Rial','iso'=>'YER']);DB::table('currencies')->insert(['name'=>'Zambian Kwacha','iso'=>'ZMW']);DB::table('currencies')->insert(['name'=>'Zimbabwe Dollar','iso'=>'ZWL']);DB::table('currencies')->insert(['name'=>'Bond Markets Unit European Composite Unit (EURCO)','iso'=>'XBA']);DB::table('currencies')->insert(['name'=>'Bond Markets Unit European Monetary Unit (E.M.U.-6)','iso'=>'XBB']);DB::table('currencies')->insert(['name'=>'Bond Markets Unit European Unit of Account 9 (E.U.A.-9)','iso'=>'XBC']);DB::table('currencies')->insert(['name'=>'Bond Markets Unit European Unit of Account 17 (E.U.A.-17)','iso'=>'XBD']);DB::table('currencies')->insert(['name'=>'Codes specifically reserved for testing purposes','iso'=>'XTS']);DB::table('currencies')->insert(['name'=>'The codes assigned for transactions where no currency is involved','iso'=>'XXX']);DB::table('currencies')->insert(['name'=>'Gold','iso'=>'XAU']);DB::table('currencies')->insert(['name'=>'Palladium','iso'=>'XPD']);DB::table('currencies')->insert(['name'=>'Platinum','iso'=>'XPT']);DB::table('currencies')->insert(['name'=>'Silver','iso'=>'XAG']);
    }
}