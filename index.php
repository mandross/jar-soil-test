<?php
function get_input($key) {
    return isset($_GET[$key]) && $_GET[$key] !== '' ? floatval($_GET[$key]) : null;
}

$a = get_input('a');
$b = get_input('b');
$c = get_input('c');

$count = 0;
if ($a !== null) $count++;
if ($b !== null) $count++;
if ($c !== null) $count++;

if ($count >= 2) {
    if ($a === null) {
        $a = 100 - $b - $c;
    } elseif ($b === null) {
        $b = 100 - $a - $c;
    } elseif ($c === null) {
        $c = 100 - $a - $b;
    }
}

$valid = $a !== null && $b !== null && $c !== null && $a >= 0 && $b >= 0 && $c >= 0 && abs($a + $b + $c - 100) < 1e-6;

if ($valid) {
    // vertex coordinates of an equilateral triangle
    $xA = 50;  $yA = 0;     // top (100% A)
    $xB = 0;   $yB = 86.6;  // bottom left (100% B)
    $xC = 100; $yC = 86.6;  // bottom right (100% C)
    $x = ($a * $xA + $b * $xB + $c * $xC) / 100;
    $y = ($a * $yA + $b * $yB + $c * $yC) / 100;
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
    </style>
</head>
<body>
<h1>Ternary Point Calculator</h1>
<form>
    <label>A (%) <input name="a" value="<?php echo htmlspecialchars($a ?? ''); ?>"></label><br>
    <label>B (%) <input name="b" value="<?php echo htmlspecialchars($b ?? ''); ?>"></label><br>
    <label>C (%) <input name="c" value="<?php echo htmlspecialchars($c ?? ''); ?>"></label><br>
    <button type="submit">Calculate</button>
</form>
<?php if ($valid): ?>
<p>Values: A=<?php echo round($a,2); ?>%, B=<?php echo round($b,2); ?>%, C=<?php echo round($c,2); ?>%</p>
<svg width="300" height="260" viewBox="0 0 100 86.6">
    <polygon points="50,0 0,86.6 100,86.6" fill="none" stroke="black"/>
    <circle cx="<?php echo $x; ?>" cy="<?php echo 86.6 - $y; ?>" r="2" fill="red"/>
</svg>
<?php elseif ($count >= 2): ?>
<p>Invalid values. Please ensure they are non-negative and sum to 100.</p>
<?php endif; ?>
</body>
</html>
