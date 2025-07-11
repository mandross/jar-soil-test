<?php
function get_input($key) {
    return isset($_GET[$key]) && $_GET[$key] !== '' ? floatval($_GET[$key]) : null;
}

$sa = get_input('sa');
$sl = get_input('sl');
$ca = get_input('ca');

$sum = $sa + $sl + $ca;
if(!$sum || $sum == 0)
{
    $sum = 1;
}

$a = 100 * $ca / $sum;
$b = 100 * $sa / $sum;

$xA = 50;  $yA = 0;     // top (100% A)
$xB = 0;   $yB = 86.6;  // bottom left (100% B)
$xC = 100; $yC = 86.6;  // bottom right (100% C)
$x = 100 - $b - 0.57735 * 0.866 * $a;
$y = 0.866 * (100 - $a);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ternary Diagram</title>
    <style>
        body { font-family: Arial, sans-serif; }
        svg { background: #f9f9f9; }
    </style>
</head>
<body>
<h1>Ternary Point Calculator</h1>
<form>
    <label>Sand (mm) <input name="sa" value="<?php echo htmlspecialchars($sa ?? ''); ?>"></label><br>
    <label>Slit (mm) <input name="sl" value="<?php echo htmlspecialchars($sl ?? ''); ?>"></label><br>
    <label>Clay (mm) <input name="ca" value="<?php echo htmlspecialchars($ca ?? ''); ?>"></label><br>
    <button type="submit">Calculate</button>
</form>
<?php if ($sum): ?>
<!-- <p>Values: A=<?php echo round($a,2); ?>%, B=<?php echo round($b,2); ?>%, C=<?php echo round($c,2); ?>%</p> -->
<svg width="300" height="260" viewBox="0 0 100 86.6">
    <polygon points="50,0 0,86.6 100,86.6" fill="none" stroke="black"/>
    <circle cx="<?php echo $x; ?>" cy="<?php echo $y; ?>" r="2" fill="red"/>
</svg>
<?php elseif (!$sum): ?>
<p>Invalid values. Please ensure they are non-negative and sum to 100.</p>
<?php endif; ?>
</body>
</html>
