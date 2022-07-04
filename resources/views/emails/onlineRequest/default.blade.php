<html>
<body style="margin: 0;padding: 0;mso-line-height-rule: exactly;min-width: 100%;background: #f4f5f7;display: flex;justify-content: center;">
<center class="wrapper" style="display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #ffffff;">
    @component('components.email-header')@endcomponent


    <div class="spacer" style="font-size: 1px;line-height: 16px;width: 100%;">&nbsp;</div>

    <table class="main center" width="602" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0;-webkit-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);-moz-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);margin: 0 auto;width: 602px;">
        <tbody class="email-template" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);background: #fff;text-align: justify;">
        <tr>
            <td class="column" style="padding: 0;vertical-align: top;text-align: left;background-color: #ffffff;font-size: 14px;">
                <div class="column-top" style="font-size: 24px;line-height: 24px;">&nbsp;</div>
                <table class="content" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0;width: 100%;">
                    <tbody class="email-template" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);background: #fff;text-align: justify;">
                    <tr>
                        <td class="padded" style="padding: 0 24px;vertical-align: top;">
                            <h1 style="margin-top: 0;margin-bottom: 16px;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 20px;line-height: 28px;"><a class="logo" href="{{ url('/') }}" style="text-decoration: none;color: #949494;"><img src="{{ url('storage/logo') }}" style="display: block;border: 0;-ms-interpolation-mode: bicubic;"></a></h1>

                            <h2 style="margin-top: 0;font-family: 'Roboto Slab', Helvetica, serif;color: #1f91f3;font-size: 1.3em;">{{ $subject }}</h2>

                            <p style="margin-top: 0;margin-bottom: 12px;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{ $name }} ({{$email}}) {{trans('emails/online_request.text')}} {{ $document }}</p>


                          <p style="margin-top: 0;margin-bottom: 16px;color: #212121;font-family: Roboto, Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 24px;"><strong>{{trans('emails/online_request.description')}}</strong></p>
                          <p style="margin-top: 0;margin-bottom: 16px;color: #212121;font-family: Roboto, Helvetica, sans-serif;font-weight: 400;font-size: 16px;line-height: 24px;">{{ $description }}</p>



                            @component('components.email-footer')
                            @endcomponent

                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

</center>
</body>
</html>