@php

$institutionalWebsite = \App\Models\Config::where('name', 'homepage')->first();
$institutionName = \App\Models\Config::where('name', 'institution')->first();

@endphp

<table class="top-panel center" width="600" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0;margin: 0 auto;width: 600px;">
    <tbody>
    <tr>
        <td class="title" width="300" style="padding: 8px 0;vertical-align: top;text-align: left;width: 300px;color: #616161;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 12px;line-height: 14px;">{{env('APP_TITLE')}}</td>
        <td class="subject" width="300" style="padding: 8px 0;vertical-align: top;text-align: right;width: 300px;color: #616161;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 12px;line-height: 14px;"><a class="strong" href="{{$institutionalWebsite->value}}" target="_blank" style="text-decoration: none;color: #949494;font-weight: 700;">{{$institutionName->value}}</a></td>
    </tr>
    <tr>
        <td class="border" colspan="2" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e0e0e0;width: 1px;">&nbsp;</td>
    </tr>
    </tbody>
</table>