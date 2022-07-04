
<html>
<body style="margin: 0;padding: 0;mso-line-height-rule: exactly;min-width: 100%;background: #f4f5f7;display: flex;justify-content: center;">
<center class="wrapper" style="display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background: #f4f5f7;margin-top: 20px;">
    @component('components.email-header')@endcomponent


    <div class="spacer" style="font-size: 1px;line-height: 16px;width: 100%;">&nbsp;</div>

    <table class="center" width="600" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0;margin: 0 auto;width: 600px;">
        <tbody>
        <tr>
            <td class="column" style="padding: 0;vertical-align: top;text-align: justify;font-size: 14px;">

                <table class="content" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0;width: 100%;">
                    <tbody class="email-template" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);background: #fff;text-align: justify;">
                    <tr>
                        <td class="padded" style="padding: 40px;vertical-align: top;">
                            <h1 style="margin-top: 0;margin-bottom: 16px;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 20px;line-height: 28px;"><a class="logo" href="{{ url('/') }}" style="text-decoration: none;color: #949494;"><img src="{{ url('storage/logo') }}" style="display: block;border: 0;-ms-interpolation-mode: bicubic;"></a></h1>

                            <h2 style="margin-top: 0;font-family: 'Roboto Slab', Helvetica, serif;color: #1f91f3;font-size: 1.3em;">{{__("emails.request-modification-confirmed-title")}}</h2>

                            <p style="margin-top: 0;margin-bottom: 12px;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{__("emails.dear",["name"=>$name])}},</p>

                            <p style="margin-top: 0;margin-bottom: 12px;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{__("emails.request-modification-confirmed-project")}} <strong style="font-weight: 700;">{{ $project }}</strong> {{__("emails.in")}} <strong style="font-weight: 700;">{{ $section }}</strong> {{__("emails.request-modification-confirmed-section")}}</p>

                            <div class="user-information">
                                <div>
                                    <button id="welcome-button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" style="cursor: pointer;display: inline-block;outline: 0;outline-offset: 0;-webkit-text-size-adjust: none;mso-hide: all;border: 1px solid #1f91f3;border-radius: 2px;line-height: 36px;text-align: center;text-transform: uppercase;width: 250px;height: 36px;background-color: #1f91f3;color: #fff;margin-top: 5px;margin-bottom: 15px;"><a href="{{url('tasks')}}" target="_blank" style="text-decoration: none;color: #fff;">{{__("emails.rfm-check")}}</a></button>
                                </div>
                                <p style="margin-top: 0;margin-bottom: 5px;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{__("emails.register_follow_link")}}:</p>

                                <p style="margin-bottom: 12px;margin-top: 0;color: #212121;font-family: 'Roboto', Helvetica, sans-serif;font-weight: 400;font-size: 14px;line-height: 20px;">{{route('tasks-management')}}</p>
                            </div>

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
