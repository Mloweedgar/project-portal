<div class="row content-row">
    <div class="col-md-12">
        <div class="no-results-container">
            <svg class="no-results-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="220" height="220" viewBox="0 0 220 220">
                <title>Missing Data</title>
                <defs>
                    <path id="a" d="M110 220c60.75 0 110-49.25 110-110S170.75 0 110 0 0 49.25 0 110s49.25 110 110 110z"></path>
                    <linearGradient x1="24.601%" y1="1.766%" x2="73.478%" y2="100%" id="c">
                        <stop stop-opacity=".06" offset="0%"></stop>
                        <stop stop-color="#DB4C3F" stop-opacity="0" offset="100%"></stop>
                    </linearGradient> </defs> <g fill="none" fill-rule="evenodd">
                    <mask id="b" fill="#fff">
                        <use xlink:href="#a"></use>
                    </mask>
                    <use class="big-circle" fill="#008BD4" xlink:href="#a"></use>
                    <circle class="middle-circle" xmlns="http://www.w3.org/2000/svg" fill="#00A9FF" mask="url(#b)" cx="110" cy="112" r="89"></circle>
                    <path class="white-circle" xmlns="http://www.w3.org/2000/svg" d="M169.947 115c.035-.83.053-1.665.053-2.504C170 78.863 143.137 52 110 52s-60 26.863-60 60.496c0 .84.018 1.673.053 2.504h119.894z" fill="#FFFFFF" mask="url(#b)"></path>
                    <path class="bottom-circle" d="M219.888 115C217.274 173.43 169.076 220 110 220 50.924 220 2.726 173.43.112 115h219.776z" fill="#003F8E" mask="url(#b)"></path>
                    <path class="shadow" d="M54 122l-3 2 92.282 96H220v-44l-52-54H54z" opacity="1" fill="url(#c)" mask="url(#b)"></path>
                    <rect class="first-line" fill="#AEF8FF" mask="url(#b)" x="51" y="122" width="118" height="3" rx=".764"></rect>
                    <g class="second-line">
                        <rect class="left" fill="#40D1FF" mask="url(#b)" x="61" y="131" width="57" height="3" rx=".764"></rect>
                        <rect class="right" fill="#40D1FF" mask="url(#b)" x="128" y="131" width="29" height="3" rx=".764"></rect>
                    </g>
                    <g class="third-line">
                        <rect class="left" fill="#00A9FF" mask="url(#b)" x="71" y="141" width="20" height="3" rx=".764"></rect>
                        <rect class="right" fill="#00A9FF" mask="url(#b)" x="102" y="141" width="45" height="3" rx=".764"></rect>
                    </g>
                    <rect class="fourth-line" fill="#008BD4" mask="url(#b)" x="86" y="151" width="47" height="3" rx=".756"></rect>
                </g>
            </svg>
            <div class="no-results-header">{{__("components.no-results-title")}}</div>
            {{-- <div class="no-results-subheader">{{__("components.no-results-subtitle")}}</div> --}}
        </div>

    </div>
</div>