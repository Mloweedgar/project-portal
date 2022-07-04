<?php

namespace Kenya;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entities')->insert([
            'id' => '1',
            'name' => 'Kenya Urban Roads Authority (KURA)',
            'description' => 'Kenya Urban Roads Authority  (KURA) is a State Corporation  under the Ministry of Transport and Infrastructure established  by the  Kenya  Roads  Act,  2007  with  the  core  mandate  of  management, development, rehabilitation and maintenance of  all  public  roads  in  Cities  and  Municipalities in  Kenya  except  where  those  roads  are National  Roads.',
            'tel' => '020 8013844',
            'email' => 'info@kura.go.ke',
            'facebook' => '',
            'twitter' => 'https://twitter.com/aninver?lang=es',
            'instagram' => '',
            'url' => 'http://kura.go.ke/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '2',
            'name' => 'Kenya National Highways Authority (KeNHA)',
            'description' => 'Kenya National Highways Authority (KeNHA) is a state corporation, established under the Kenya Roads Act 2007 with the responsibility for the management, development, rehabilitation and maintenance of international trunk roads linking centres of international importance and crossing international boundaries or terminating at international ports(Class A road), national trunk roads linking internationally important centres (Class B roads), and primarily roads linking provincially important centres to each other or two higher-class roads (Class C roads).In undertaking this mandate, the Authority propels the country to achieve its infrastructure goals espoused in the vision 2030.',
            'address' => 'Blue Shield Towers, Hospital Road, Upper Hill P.O.BOX 49712-00100 Nairobi.',
            'tel' => '+254 020 2989000',
            'email' => 'dg@kenha.co.ke',
            'facebook' => 'https://www.facebook.com/KeNHAKenya1/?ref=py_c',
            'twitter' => 'https://twitter.com/keNHAkenya',
            'instagram' => '',
            'url' => 'http://www.kenha.co.ke/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '3',
            'name' => 'Ministry of Transport and Infrastructure (MOTI)',
            'description' => 'Our Vision: To be global leader in provision of transport infrastructure, maritime economy, the built environment and sustainable urban development. Our Mission: "To develop and sustain world class transport infrastructure, maritime economy, public works and housing for sustainable socio-economic development"',
            'address' => 'Ministry of Transport, Infrastructure, Housing and Urban Development, Transcom House, NGONG ROAD, P.o Box 52692 - 00200, NAIROBI, KENYA',
            'tel' => '+254-020-2729200',
            'email' => '',
            'facebook' => 'https://www.facebook.com/Ministry-of-Transport-and-Infrastructure-GoK-493194307419924/?fref=ts',
            'twitter' => 'https://twitter.com/transportke',
            'instagram' => '',
            'url' => 'http://www.transport.go.ke',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '4',
            'name' => 'Kenya Rural Roads Authority (KeRRA)',
            'description' => 'Kenya Rural Roads Authority is a State Corporation whose mandate is to offer guidance in the construction, maintenance and management of the rural road network in the country. KeRRA is responsible for themanagement, development, rehabilitation, and maintenance of rural roads (D, E & Others).',
            'address' => 'Kenya Rural Roads Authority, Blueshield Towers, Upperhill, 6th Floor, P.o. Box 48151-00100, Nairobi. Kenya.',
            'tel' => '+254 (20) 2710464',
            'email' => 'kerra@kerra.go.ke',
            'facebook' => 'https://www.facebook.com/Kenya-Rural-Roads-Authority-1411815469063422/',
            'twitter' => 'https://twitter.com/KeRRA_Ke',
            'instagram' => '',
            'url' => 'http://www.kerra.go.ke/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '5',
            'name' => 'Kenya Ports Authority (KPA)',
            'description' => 'Established in January 1978 under an Act of Parliament, KPA is mandated to manage and operate the Port of Mombasa and all scheduled seaports along Kenya’s coastline that include Lamu, Malindi, Kilifi, Mtwapa, Kiunga, Shimoni, Funzi and Vanga. In addition, the Authority manages Inland Waterways as well as Inland Container Depots at Embakasi, Eldoret and Kisumu.',
            'address' => 'Kenya Ports Authority P.O. Box 95009-80104 Mombasa.',
            'tel' => '+254709092999',
            'email' => 'kpa_careers@kpa.co.ke',
            'facebook' => 'https://www.facebook.com/KenyaPortsAuthority',
            'twitter' => 'https://twitter.com/Kenya_Ports',
            'instagram' => '',
            'url' => 'https://www.kpa.co.ke',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '6',
            'name' => 'Kenya Ferry Services Limited (KFSL)',
            'description' => 'Ferry services at Likoni Mombasa started in 1937. The ferries have remained the one and only link to the south coast. The operations are situated on the gateway to the port of Mombasa. The link is important not only to the local users but to those heading to Tanzania and beyond.',
            'address' => 'Po Box 96242-80110, Mombasa, Kenya',
            'tel' => '(+254) 20 2118344',
            'email' => 'info@kenyaferry.co.ke',
            'facebook' => 'https://www.facebook.com/ferry.kenya/',
            'twitter' => 'http://www.twitter.com/FerryKenya',
            'instagram' => '',
            'url' => 'https://www.kenyaferry.co.ke',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '7',
            'name' => 'Kenya Railways Corporation (KRC)',
            'description' => 'Kenya Railways was established by an Act of Parliament (Cap 397) of the Laws of Kenya, and commenced operations on January 20, 1978. The overall mandate of the Corporation then was to provide a coordinated and integrated system within Kenya of rail and inland waterways transport services and inland port facilities.',
            'address' => 'P.O Box 30121 – 00100, Nairobi Kenya',
            'tel' => '0709907000',
            'email' => 'info@krc.co.ke',
            'facebook' => 'https://www.facebook.com/ferry.kenya/',
            'twitter' => 'http://www.twitter.com/FerryKenya',
            'instagram' => '',
            'url' => 'http://krc.co.ke/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '8',
            'name' => 'Kenya Civil Aviation Authority (KCAA)',
            'description' => 'Kenya Civil Aviation Authority (KCAA) was established on 24th October 2002 by the Civil Aviation (Amendment) Act, 2002 with the primary functions towards; Regulation and oversight of Aviation Safety & Security; Economic regulation of Air Services and development of Civil Aviation; Provision of Air Navigation Services, and Training of Aviation personnel KCAA; as guided by the provisions of the convention on international civil aviation, related ICAO Standards and Recommended Practices (SARPs), the Kenya Civil Aviation Act, 2013 and the civil aviation regulations.',
            'address' => 'P.O Box 30121 – 00100, Nairobi Kenya',
            'tel' => '0709907000',
            'email' => 'info@krc.co.ke',
            'facebook' => 'https://www.facebook.com/kcaake/',
            'twitter' => 'https://twitter.com/caa_kenya',
            'instagram' => '',
            'url' => 'http://www.kcaa.or.ke/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

        DB::table('entities')->insert([
            'id' => '9',
            'name' => 'Public Private Partnership Unit (PPPU)',
            'description' => 'The PPP Units focus is to serve as the secretariat and technical arm of the PPP Committee, which is mandated with assessing and approving PPP projects in the country.',
            'address' => 'Public Private Partnership (PPP) Unit, National Treasury, P.O BOX 30007 - 00100, Nairobi, KENYA.',
            'tel' => '020 - 2252299',
            'email' => 'info@pppunit.go.ke',
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'url' => 'http://www.pppunit.go.ke/',
            'draft' => '0',
            'requested_modification' => '0',
            'published' => '0',
        ]);

    }
}
