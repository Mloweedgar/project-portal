@php

    $address = \App\Models\Config::where('name','address')->first()->value;
    $phone = \App\Models\Config::where('name','phone')->first()->value;
    $short = \App\Models\Config::where('name','institution_short')->first()->value;
    $email = \App\Models\Config::where('name','mail')->first()->value;


@endphp

<p style="margin-top: 0;margin-bottom: 12px;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{__("emails.contact")}}: <a href="mailto:{{$email}}" style="text-decoration: none;color: #949494;">{{$email}}</a></p>

<p style="margin-bottom: 0;margin-top: 0;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{__("emails.regards")}},</p>
<p style="margin-top: 0;margin-bottom: 0;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{$short}}</p>
<p style="margin-top: 0;margin-bottom: 0;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{$address}}</p>
<p style="margin-top: 0;margin-bottom: 0;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{$phone}}</p>
<p style="color: #999999;font-size: 12px;margin-bottom: 0;margin-top: 0;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;line-height: 20px;">*{{__("emails.recipient")}}</p>