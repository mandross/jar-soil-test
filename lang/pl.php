<?php
return [
    'title' => 'Test Słoikowy',
    'sand_mm' => 'Poziom piasku (mm)',
    'silt_mm' => 'Poziom pyłu (mm)',
    'clay_mm' => 'Poziom gliny (mm)',
    'calculate' => 'Oblicz',
    'all_fields' => 'Wszystkie pola są wymagane.',
    'sand_err' => 'Poziom piasku musi być ≥ 0.',
    'silt_err' => 'Poziom pyłu musi być większy niż piasku.',
    'clay_err' => 'Poziom gliny musi być większy niż pyłu.',
    'sum_err' => 'Suma warstw musi być równa poziomowi gliny.',
    'howto' => 'Instrukcja',
    'step1' => 'Weź próbkę gleby z pełnego profilu (35-40 cm).',
    'step2' => 'Przetrzyj ją przez grube sito.',
    'step3' => 'Napełnij przezroczysty słoik do jednej trzeciej ziemią.',
    'step4' => 'Dodaj wodę i łyżkę proszku do zmywarki zostawiając miejsce.',
    'step5' => 'Mocno wstrząsaj minutę lub dwie.',
    'step6' => 'Pozostaw słoik na 24 godziny.',
    'step7' => 'Zmierz warstwy piasku, pyłu i gliny jak poniżej.',
    'pre_clay_level' => 'Poziom gliny [mm]',
    'pre_clay' => '|        Glina            |',
    'pre_silt_level' => 'Poziom pyłu [mm]',
    'pre_silt' => '|         Pył             |',
    'pre_sand_level' => 'Poziom piasku [mm]',
    'pre_sand' => '|        Piasek           |',
    'pre_zero' => '0 mm (dno)',
    'triangle_svg' => <<<'SVG'
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="95%" height="95%" viewBox="-219 -20 440 420">
 <title>SoilTexture USDA</title>
 <desc>A soil texture diagram redrawn from the USDA webpage http://nrcs.usda.gov/Internet/FSE_MEDIA/nrcs142p2_050242.jpg with colours from http://commons.wikimedia.org/wiki/File:SoilTexture_USDA.png by CMG Lee.</desc>
 <style type="text/css">
#main  { font-size:16px; font-family:Helvetica,Arial,sans-serif; text-anchor:middle;
         fill:#000000; stroke-linejoin:round; }
text   { stroke:none; cursor:default; }
.clay  { fill:#0000ff; stroke:#0000ff; text-anchor:end; }
.sand  { fill:#009900; stroke:#009900; text-anchor:start; }
.silt  { fill:#cc0000; stroke:#cc0000; text-anchor:start; }
.arrow { text-anchor:middle; }
.thick { stroke-width:2; }
.point { fill:#000000; stroke:none; text-anchor:start; }
 </style>
 <defs>
  <pattern id="pattern_grid" patternUnits="userSpaceOnUse" width="40" height="80">
   <g stroke-width="0.3">
    <path class="clay" d="M 0, 0 h 40 M 0,40 h 40 M 0,80 h 40"/>
    <path class="silt" d="M 0,80 l 40,-80"/>
    <path class="sand" d="M 0, 0 l 40,80"/>
   </g>
   <g stroke-width="0.5" stroke-dasharray="1,1.5">
    <path class="clay" d="M 0,20 h 40 M 0,60 h 40"/>
    <path class="silt" d="M 0,40 l 20,-40 M 20,80 l 20,-40"/>
    <path class="sand" d="M 0,40 l 20,40 M 20,0 l 20,40"/>
   </g>
  </pattern>
  <path id="arrow" d="M -100,-35 H 100 m -10,-5 l 10,5 l -10,5" fill="none"/>
  <path id="line_clay" class="clay" d="M -100,200 H 100"/>
  <path id="line_silt" class="silt" d="M 40,80 L -120,400"/>
  <path id="line_sand" class="sand" d="M -60,120 L 80,400"/>
  <g id="sample1" class="point" transform="translate(-20,200)">
   <text transform="translate(10,10) scale(0.866,1)" y="0.6ex">Sample 1</text>
   <ellipse id="sample" rx="5" ry="6"/>
   <use xlink:href="#sample"/>
  </g>
  <g id="sample2" class="point" transform="translate(60,360)">
   <text transform="translate(10,10) scale(0.866,1)" y="0.6ex">Sample 2</text>
   <rect x="-4" y="-5" width="8" height="10"/>
  </g>
  <g id="sample3" class="point" transform="translate(-60,360)">
   <text transform="translate(10,10) scale(0.866,1)" y="0.6ex">Sample 3</text>
   <path d="M 0,-8 l 6,12 h -12"/>
  </g>
 </defs>
 <circle cx="0" cy="0" r="99999" fill="#ffffff"/>
 <g id="main" transform="scale(1,0.866)">
  <g stroke="#000000" stroke-width="1">
   <switch>
    <g class="clay thick" systemLanguage="aa">
     <text transform="translate(100,210) scale(0.866,1)" y="0.6ex">50% clay line</text>
     <use xlink:href="#line_clay"/>
    </g>
    <g class="silt thick" systemLanguage="ba">
     <text transform="translate(-120,400) scale(0.866,1) rotate(-60)" y="-0.6ex">20% silt line</text>
     <use xlink:href="#line_silt"/>
     <use xlink:href="#line_clay"/>
    </g>
    <g class="sand thick" systemLanguage="ca">
     <text transform="translate( 80,400) scale(0.866,1) rotate(60)" y="-0.6ex" text-anchor="end">30% sand line</text>
     <use xlink:href="#line_sand"/>
     <use xlink:href="#line_silt"/>
     <use xlink:href="#line_clay"/>
     <use xlink:href="#sample1"/>
    </g>
    <g systemLanguage="da">
     <use xlink:href="#sample1"/>
     <use xlink:href="#sample2"/>
     <use xlink:href="#sample3"/>
    </g>
    <g>
     <path d="M 0,0 l 80,160 l -40,80 h -100 l -30,-60 z" fill="#ffff9c"/><text transform="translate(0,150)" y="0.6ex"><tspan>glina</tspan></text>
     <path d="M -60,240 h 100 l 25,50 h -100 z" fill="#ceff63"/><text transform="translate(5,270)" y="0.6ex"><tspan>ił gliniasty</tspan></text>
     <path d="M -35,290 h 90 l -40,80 h -40 l -25,-50 z" fill="#ce9c00"/><text transform="translate(-5,330)" y="0.6ex"><tspan>ił</tspan></text>
     <path d="M -90,180 l 40,80 h -80 z" fill="#ff0000"/><text transform="translate(-90,230)" y="0.6ex"><tspan>glina</tspan><tspan x="0" dy="20">pia.</tspan></text>
     <path d="M -130,260 h 80 l 15,30 l -15,30 h -110 z" fill="#ff9c9c"/><text transform="translate(-90,290)" y="0.6ex"><tspan>Ił piaszczysto-</tspan><tspan x="0" dy="20">gliniasty</tspan></text>
     <path d="M -160,320 h 110 l 25,50 h 40 l -15,30 h -80 l -90,-60 z" fill="#ffceff"/><text transform="translate(-90,350)" y="0.6ex"><tspan>ił piaszczysty</tspan></text>
     <path d="M -170,340 l 90,60 h -60 l -40,-40 z" fill="#ffcece"/><text transform="translate(-142,375) scale(0.95,1)" y="0.6ex"><tspan>pias.</tspan><tspan x="13" dy="13">ilasty</tspan></text>
     <path d="M -180,360 l 40,40 h -60 z" fill="#ffce9c"/><text transform="translate(-175,390)" y="0.6ex"><tspan>pias.</tspan></text>
     <path d="M 80,160 l 40,80 h -80 z" fill="#9cffce"/><text transform="translate(80,210)" y="0.6ex"><tspan>glina</tspan><tspan x="0" dy="20">pylasta</tspan></text>
     <path d="M 40,240 h 80 l 25,50 h -80 z" fill="#63ce9c"/><text transform="translate(90,250)" y="0.6ex"><tspan>ił pylasto-</tspan><tspan x="5" dy="20">gliniasty</tspan></text>
     <path d="M 55,290 h 90 l 30,60 h -30 l -25,50 h -120 z" fill="#9cce00"/><text transform="translate(90,350)" y="0.6ex"><tspan>ił pylasty</tspan></text>
     <path d="M 145,350 h 30 l 25,50 h -80 z" fill="#00ff31"/><text transform="translate(160,370)" y="0.6ex"><tspan>pył</tspan></text>
    </g>
   </switch>
   <path d="M 0,0 l 200,400 h -400 Z" fill="url(#pattern_grid)"/>
  </g>
  <g class="clay axis">
   <g class="arrow" transform="translate(-100,200) scale(0.866,1) rotate(-60)">
    <use xlink:href="#arrow"/>
    <text y="0.6ex" dy="-50">Udział gliny (%)</text>
   </g>
   <text transform="translate(   0,  0) scale(0.866,1)" y="0.5ex">100&#8202;-</text>
   <text transform="translate( -20, 40) scale(0.866,1)" y="0.5ex" >90&#8202;-</text>
   <text transform="translate( -40, 80) scale(0.866,1)" y="0.5ex" >80&#8202;-</text>
   <text transform="translate( -60,120) scale(0.866,1)" y="0.5ex" >70&#8202;-</text>
   <text transform="translate( -80,160) scale(0.866,1)" y="0.5ex" >60&#8202;-</text>
   <text transform="translate(-100,200) scale(0.866,1)" y="0.5ex" >50&#8202;-</text>
   <text transform="translate(-120,240) scale(0.866,1)" y="0.5ex" >40&#8202;-</text>
   <text transform="translate(-140,280) scale(0.866,1)" y="0.5ex" >30&#8202;-</text>
   <text transform="translate(-160,320) scale(0.866,1)" y="0.5ex" >20&#8202;-</text>
   <text transform="translate(-180,360) scale(0.866,1)" y="0.5ex" >10&#8202;-</text>
   <text transform="translate(-200,400) scale(0.866,1)" y="0.5ex"  >0&#8202;-</text>
  </g>
  <g class="silt axis">
   <g class="arrow" transform="translate(100,200) scale(0.866,1) rotate(60)">
    <use xlink:href="#arrow"/>
    <text y="0.6ex" dy="-50">Udział pyłu (%)</text>
   </g>
   <text transform="translate(  0,  0) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;0</text>
   <text transform="translate( 20, 40) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8202;10</text>
   <text transform="translate( 40, 80) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;20</text>
   <text transform="translate( 60,120) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;30</text>
   <text transform="translate( 80,160) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;40</text>
   <text transform="translate(100,200) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;50</text>
   <text transform="translate(120,240) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;60</text>
   <text transform="translate(140,280) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;70</text>
   <text transform="translate(160,320) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;80</text>
   <text transform="translate(180,360) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8201;90</text>
   <text transform="translate(200,400) scale(0.866,1) rotate(-60)" y="0.5ex">-&#8202;100</text>
  </g>
  <g class="sand axis">
   <g class="arrow" transform="translate(0,400) scale(0.866,1) rotate(180)">
    <use xlink:href="#arrow"/>
    <text transform="rotate(180)" y="0.6ex" dy="50">Udział piasku (%)</text>
   </g>
   <text transform="translate(-200,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8202;100</text>
   <text transform="translate(-160,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;90</text>
   <text transform="translate(-120,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;80</text>
   <text transform="translate( -80,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;70</text>
   <text transform="translate( -40,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;60</text>
   <text transform="translate(   0,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;50</text>
   <text transform="translate(  40,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;40</text>
   <text transform="translate(  80,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;30</text>
   <text transform="translate( 120,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;20</text>
   <text transform="translate( 160,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8202;10</text>
   <text transform="translate( 200,400) scale(0.866,1) rotate(60)" y="0.5ex">-&#8201;0</text>
  </g>
 </g>
 <circle cx="{X}" cy="{Y}" r="5" fill="black"/>
</svg>
SVG,
];
