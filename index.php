<?php
function get_input($key) {
    return isset($_GET[$key]) && $_GET[$key] !== '' ? floatval($_GET[$key]) : null;
}

$sa = get_input('sa');
$sl = get_input('sl');
$ca = get_input('ca');

$errors = [];

// Validation
if ($_GET) {
    if ($sa === null || $sl === null || $ca === null) {
        $errors[] = 'All fields are required.';
    } else {
        if ($sa < 0) $errors[] = 'Sand must be greater than or equal to 0.';
        if ($sl < 0) $errors[] = 'Silt must be greater than or equal to 0.';
        if ($ca < 0) $errors[] = 'Clay must be greater than or equal to 0.';
        $sum = $sa + $sl + $ca;
        if ($sum <= 0) $errors[] = 'The sum of all values must be greater than 0.';
    }
} else {
    $sum = $sa + $sl + $ca;
}

if (empty($errors)) {
    if(!$sum || $sum == 0) {
        $sum = 1;
    }

    $a = 100 * $ca / $sum;
    $b = 100 * $sa / $sum;

    $xA = 50;  $yA = 0;     // top (100% A)
    $xB = 0;   $yB = 86.6;  // bottom left (100% B)
    $xC = 100; $yC = 86.6;  // bottom right (100% C)
    $x = 100 - $b - 0.57735 * 0.866 * $a;
    $y = 0.866 * (100 - $a);

    // New triangle points
    $X_A = 0; $Y_A = 0;
    $X_B = -200; $Y_B = 346;
    $X_C = 200; $Y_C = 346;

    // Compute barycentric coordinates
    $denom = (($yB - $yC)*($xA - $xC) + ($xC - $xB)*($yA - $yC));
    $u = (($yB - $yC)*($x - $xC) + ($xC - $xB)*($y - $yC)) / $denom;
    $v = (($yC - $yA)*($x - $xC) + ($xA - $xC)*($y - $yC)) / $denom;
    $w = 1 - $u - $v;

    // Map to new triangle
    $X = $u * $X_A + $v * $X_B + $w * $X_C;
    $Y = $u * $Y_A + $v * $Y_B + $w * $Y_C;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ternary Diagram</title>
    <style>
        body { font-family: Arial, sans-serif; }
        svg { background: #f9f9f9; }
        .error { color: red; margin-bottom: 1em; }
    </style>
</head>
<body>
<h1>Ternary Point Calculator</h1>
<?php if (!empty($errors)): ?>
    <div class="error">
        <?php foreach ($errors as $error): ?>
            <div><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form>
    <label>Sand (mm) <input name="sa" type="number" min="0" step="any" value="<?php echo htmlspecialchars($sa ?? ''); ?>" required></label><br>
    <label>Silt (mm) <input name="sl" type="number" min="0" step="any" value="<?php echo htmlspecialchars($sl ?? ''); ?>" required></label><br>
    <label>Clay (mm) <input name="ca" type="number" min="0" step="any" value="<?php echo htmlspecialchars($ca ?? ''); ?>" required></label><br>
    <button type="submit">Calculate</button>
</form>
<?php if (empty($errors) && $sum): ?>
<!-- <p>Values: A=<?php echo round($a,2); ?>%, B=<?php echo round($b,2); ?>%, C=<?php echo round($c,2); ?>%</p> -->
<!-- <svg width="300" height="260" viewBox="0 0 100 86.6">
    <polygon points="50,0 0,86.6 100,86.6" fill="none" stroke="black"/>
    <circle cx="<?php echo $x; ?>" cy="<?php echo $y; ?>" r="2" fill="red"/>
</svg> -->
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25%" height="25%" viewBox="-219 -20 440 420">
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
     <path d="M 0,0 l 80,160 l -40,80 h -100 l -30,-60 z" fill="#ffff9c"/><text transform="translate(0,150)" y="0.6ex"><tspan>clay</tspan></text>
     <path d="M -60,240 h 100 l 25,50 h -100 z" fill="#ceff63"/><text transform="translate(5,270)" y="0.6ex"><tspan>clay loam</tspan></text>
     <path d="M -35,290 h 90 l -40,80 h -40 l -25,-50 z" fill="#ce9c00"/><text transform="translate(-5,330)" y="0.6ex"><tspan>loam</tspan></text>
     <path d="M -90,180 l 40,80 h -80 z" fill="#ff0000"/><text transform="translate(-90,230)" y="0.6ex"><tspan>sandy</tspan><tspan x="0" dy="20">clay</tspan></text>
     <path d="M -130,260 h 80 l 15,30 l -15,30 h -110 z" fill="#ff9c9c"/><text transform="translate(-90,290)" y="0.6ex"><tspan>sandy clay</tspan><tspan x="0" dy="20">loam</tspan></text>
     <path d="M -160,320 h 110 l 25,50 h 40 l -15,30 h -80 l -90,-60 z" fill="#ffceff"/><text transform="translate(-90,350)" y="0.6ex"><tspan>sandy loam</tspan></text>
     <path d="M -170,340 l 90,60 h -60 l -40,-40 z" fill="#ffcece"/><text transform="translate(-142,375) scale(0.95,1)" y="0.6ex"><tspan>loamy</tspan><tspan x="13" dy="13">sand</tspan></text>
     <path d="M -180,360 l 40,40 h -60 z" fill="#ffce9c"/><text transform="translate(-175,390)" y="0.6ex"><tspan>sand</tspan></text>
     <path d="M 80,160 l 40,80 h -80 z" fill="#9cffce"/><text transform="translate(80,210)" y="0.6ex"><tspan>silty</tspan><tspan x="0" dy="20">clay</tspan></text>
     <path d="M 40,240 h 80 l 25,50 h -80 z" fill="#63ce9c"/><text transform="translate(90,250)" y="0.6ex"><tspan>silty</tspan><tspan x="5" dy="20">clay loam</tspan></text>
     <path d="M 55,290 h 90 l 30,60 h -30 l -25,50 h -120 z" fill="#9cce00"/><text transform="translate(90,350)" y="0.6ex"><tspan>silt loam</tspan></text>
     <path d="M 145,350 h 30 l 25,50 h -80 z" fill="#00ff31"/><text transform="translate(160,370)" y="0.6ex"><tspan>silt</tspan></text>
    </g>
   </switch>
   <path d="M 0,0 l 200,400 h -400 Z" fill="url(#pattern_grid)"/>
  </g>
  <g class="clay axis">
   <g class="arrow" transform="translate(-100,200) scale(0.866,1) rotate(-60)">
    <use xlink:href="#arrow"/>
    <text y="0.6ex" dy="-50">Clay Separate (%)</text>
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
    <text y="0.6ex" dy="-50">Silt Separate (%)</text>
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
    <text transform="rotate(180)" y="0.6ex" dy="50">Sand Separate (%)</text>
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
 <circle cx="<?php echo $X; ?>" cy="<?php echo $Y; ?>" r="5" fill="black"/>
</svg>
<?php elseif (!empty($errors)): ?>
<!-- Errors shown above -->
<?php endif; ?>
</body>
</html>


