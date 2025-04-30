<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $htmlFile = $_POST['html_file'];
    $originalTag = $_POST['original_tag'];
    $newTag = $_POST['new_tag'];
    $outputType = $_POST['output_type'];
   
    if (!file_exists($htmlFile)) {
        die("Error: The file '$htmlFile' does not exist.");
    }
   


    $content = file_get_contents($htmlFile);
   


    $pattern = '/<\/?' . preg_quote($originalTag, '/') . '(\s+[^>]*)?>/i';
    $modifiedContent = preg_replace($pattern, str_replace($originalTag, $newTag, '$0'), $content);
   


    if ($outputType === 'O') {
        $outputFile = $htmlFile;
    } else {
       
        $outputFile = preg_replace('/(\.html?)$/i', '-new$1', $htmlFile);
    }
   
   
    file_put_contents($outputFile, $modifiedContent);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Result</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <div class="result-box">
                <p>Successfully replaced all &lt;<?= htmlspecialchars($originalTag) ?>&gt; tags with &lt;<?= htmlspecialchars($newTag) ?>&gt; tags.</p>
                <p>Modified content saved to: <?= htmlspecialchars($outputFile) ?></p>
                <a href="<?= $_SERVER['PHP_SELF'] ?>">&#8592; Back</a>
            </div>
        </body>
        </html>
        <?php
} else {
   
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>HTML Tag Replacer</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>HTML Tag Replacer</h1>
        <form method="POST">
            <label for="html_file">HTML File Name:</label>
            <input type="text" id="html_file" name="html_file" required><br><br>
           
            <label for="original_tag">Original Tag:</label>
            <input type="text" id="original_tag" name="original_tag" required><br><br>
           
            <label for="new_tag">New Tag:</label>
            <input type="text" id="new_tag" name="new_tag" required><br><br>
           
            <label>Output Type:</label>
            <input type="radio" id="output_o" name="output_type" value="O" checked>
            <label for="output_o">Overwrite Original (O)</label>
            <input type="radio" id="output_n" name="output_type" value="N">
            <label for="output_n">New File (N)</label><br><br>
           
            <input type="submit" value="Replace Tags">
        </form>
    </body>
    </html>
    <?php
}
?>
