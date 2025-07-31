<?php
function get_input($key) {
    return isset($_GET[$key]) && $_GET[$key] !== '' ? floatval($_GET[$key]) : null;
}

// Load translations and choose language
$trans = [];
foreach (glob(__DIR__ . '/lang/*.php') as $file) {
    $code = basename($file, '.php');
    $trans[$code] = require $file;
}
$supported = array_keys($trans);
if (isset($_GET['lang']) && in_array($_GET['lang'], $supported)) {
    $lang = $_GET['lang'];
} else {
    $browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2);
    $lang = in_array($browser, $supported) ? $browser : 'en';
}


function t($key) {
    global $trans, $lang;
    return $trans[$lang][$key] ?? $key;
}

$l1 = get_input('l1');
$l2 = get_input('l2');
$l3 = get_input('l3');

$sa = $l1;
$sl = $l2 - $sa;
$ca = $l3 - $l2;

$errors = [];
// Validation
if ($_GET) {
    if ($l1 === null || $l2 === null || $l3 === null) {
        $errors[] = t('all_fields');
    } else {
        if ($l1 < 0) $errors[]   = t('sand_err');
        if ($l2 < $l1) $errors[] = t('silt_err');
        if ($l3 < $l2) $errors[] = t('clay_err');
        $sum = $sa + $sl + $ca;
        if ($sum != $l3) $errors[] = t('sum_err');
    }
} else {
    $sum = $sa + $sl + $ca;
}

if (empty($errors)) {
    if (!$sum || $sum == 0) {
        $sum = 1;
    }
    $a = 100 * $ca / $sum;
    $b = 100 * $sa / $sum;

    $xA = 50;  $yA = 0;                // top (100% A)
    $xB = 0;   $yB = 100 * sqrt(3)/2;  // bottom left (100% B)
    $xC = 100; $yC = 100 * sqrt(3)/2;  // bottom right (100% C)
    $x = 100 - $b - tan(pi()/6) * sqrt(3)/2 * $a;
    $y = sqrt(3)/2 * (100 - $a);

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
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="utf-8">
    <title>Ternary Diagram</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 1em; }
        .container { position: relative; max-width: 800px; margin: auto; background: #fff; padding: 2em; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .lang-select { position: absolute; top: 1em; right: 1em; }
        svg { display: block; margin: 2em auto; background: #f9f9f9; }
        form label { display: block; margin-bottom: 0.5em; }
        input[type=number] { width: 100%; padding: 0.4em; margin-top: 0.2em; box-sizing: border-box; }
        button { padding: 0.5em 1em; margin-top: 1em; }
        .error { color: red; margin-bottom: 1em; }
    </style>
</head>
<body>
<div class="container">
<div class="lang-select">
    <form id="langform">
        <select name="lang" id="lang">
            <option value="en"<?php if($lang==='en') echo ' selected'; ?>>English</option>
            <option value="pl"<?php if($lang==='pl') echo ' selected'; ?>>Polski</option>
        </select>
        <?php if ($l1 !== null) { echo '<input type="hidden" name="l1" value="'.htmlspecialchars($l1).'">'; } ?>
        <?php if ($l2 !== null) { echo '<input type="hidden" name="l2" value="'.htmlspecialchars($l2).'">'; } ?>
        <?php if ($l3 !== null) { echo '<input type="hidden" name="l3" value="'.htmlspecialchars($l3).'">'; } ?>
    </form>
</div>
<h1><?php echo t('title'); ?></h1>
<?php if (!empty($errors)): ?>
    <div class="error">
        <?php foreach ($errors as $error): ?>
            <div><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form>
    <label><?php echo t('sand_mm'); ?> <input name="l1" type="number" min="0" step="any" value="<?php echo htmlspecialchars($l1 ?? ''); ?>" required></label><br>
    <label><?php echo t('silt_mm'); ?> <input name="l2" type="number" min="0" step="any" value="<?php echo htmlspecialchars($l2 ?? ''); ?>" required></label><br>
    <label><?php echo t('clay_mm'); ?> <input name="l3" type="number" min="0" step="any" value="<?php echo htmlspecialchars($l3 ?? ''); ?>" required></label><br>
    <input type="hidden" name="lang" value="<?php echo $lang; ?>">
    <button type="submit"><?php echo t('calculate'); ?></button>
</form>
<?php if (empty($errors) && $sum): ?>
<!-- <p>Values: A=<?php echo round($a,2); ?>%, B=<?php echo round($b,2); ?>%, C=<?php echo round($c,2); ?>%</p> -->
<!-- <svg width="300" height="260" viewBox="0 0 100 86.6">
    <polygon points="50,0 0,86.6 100,86.6" fill="none" stroke="black"/>
    <circle cx="<?php echo $x; ?>" cy="<?php echo $y; ?>" r="2" fill="red"/>
</svg> -->
<?php echo strtr(t('triangle_svg'), ['{X}' => $X, '{Y}' => $Y]); ?>
<h2><?php echo t('howto'); ?></h2>
<ol>
  <li><?php echo t('step1'); ?></li>
  <li><?php echo t('step2'); ?></li>
  <li><?php echo t('step3'); ?></li>
  <li><?php echo t('step4'); ?></li>
  <li><?php echo t('step5'); ?></li>
  <li><?php echo t('step6'); ?></li>
  <li><?php echo t('step7'); ?></li>
</ol>
<pre>
|                         |
|-------------------------| ← <?php echo t('pre_clay_level'); ?>

<?php echo t('pre_clay'); ?>

|-------------------------| ← <?php echo t('pre_silt_level'); ?>

<?php echo t('pre_silt'); ?>

|-------------------------| ← <?php echo t('pre_sand_level'); ?>

<?php echo t('pre_sand'); ?>

|-------------------------| ← <?php echo t('pre_zero'); ?>
</pre>
<?php elseif (!empty($errors)): ?>
<!-- Errors shown above -->
<?php endif; ?>
</div>
<script>
 document.getElementById('lang').addEventListener('change', function(){
   document.getElementById('langform').submit();
 });
</script>
</body>
</html>
