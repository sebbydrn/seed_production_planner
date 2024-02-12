<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">

    <style>
        #bgimg {
          position: fixed;
          left: -.5in;
          top: -.5in;
          width: 20.1in;
          height: 8.1in;
          z-index: -999
        }
    </style>
</head>
<body>
	<img src="<?php echo $_SERVER['DOCUMENT_ROOT'] . '/seed_production_planner/public/images/qrcode_bg2.png' ?>" alt="" id="bgimg">

	<table style="width: 100%;">
        <tr>
            <td style="width: 30%; margin-top: 20px;">
                <p style="text-align: center;"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(480)->margin(2)->generate($productionPlotCode->production_plot_code)) }}" align="middle"></p>

                <h1 style="text-align: center; font-family: sans-serif; font-size: 30px; color: white;">{{ $productionPlotCode->production_plot_code }}</h1>
            </td>
            <td style="width: 70%;">
                @if($productionPlan->seed_class == "Nucleus")
                    @php
                        $seed_class =  "NS";
                    @endphp
                @elseif($productionPlan->seed_class == "Breeder")
                    @php
                        $seed_class =  "BS";
                    @endphp
                @elseif($productionPlan->seed_class == "Foundation")
                    @php
                        $seed_class =  "FS";
                    @endphp
                @elseif($productionPlan->seed_class == "Registered")
                    @php
                        $seed_class =  "RS";
                    @endphp
                @endif

                <h1 style="text-align: center; font-family: sans-serif; font-size: 150px; color: white;">{{ $productionPlan->variety }} ({{$seed_class}})</h1>

                {{-- <h2 style="text-align: center; font-family: sans-serif; font-size: 60px; color: white; margin-top: 70px;">Area ({{$totalArea}} ha) / {{$seedChar->ecosystem}} / {{$seedChar->maturity}} DAS</h2> --}}

                <h2 style="text-align: center; font-family: sans-serif; font-size: 60px; color: white; margin-top: 70px;">{{$seedChar->ecosystem}} / {{$seedChar->maturity}} DAS</h2>

                {{-- <p style="text-align: center; font-family: sans-serif; color: white; font-size: 30px; margin-top: 50px;">
	                @foreach($plots as $plot)
	                	{{$plot}} | 
	                @endforeach
                </p> --}}
            </td>
        </tr>
    </table>
</body>
</html>


{{-- <img src="data:image/png;base64, {{base64_encode(QrCode::format('png')->size(200)->margin(0)->generate($productionPlotCode->production_plot_code))}}" alt=""> --}}