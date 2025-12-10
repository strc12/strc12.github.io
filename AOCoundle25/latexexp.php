<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload LaTeX and Generate PDF</title>
<script src="https://cdn.jsdelivr.net/npm/latex.js/dist/latex.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
<h2>Upload LaTeX File to PDF</h2>

<input type="file" id="latexFile" accept=".tex">
<br><br>
<button onclick="generatePDF()">Generate PDF</button>

<script>
async function generatePDF() {
    const { jsPDF } = window.jspdf;
    const fileInput = document.getElementById('latexFile');
    
    if (!fileInput.files.length) {
        alert("Please select a .tex file first.");
        return;
    }

    const file = fileInput.files[0];
    const text = await file.text(); // Read file content

    // Parse LaTeX to HTML
    const generator = new latexjs.HtmlGenerator({ hyphenate: false });
    latexjs.parse(text, { generator });
    const htmlContent = generator.domFragment().outerHTML;

    // Generate PDF
    const doc = new jsPDF();
    doc.html(htmlContent, {
        callback: function (doc) {
            doc.save(file.name.replace(/\.tex$/i, ".pdf")); // Save as PDF
        },
        x: 10,
        y: 10,
        width: 190
    });
}
</script>
</body>
</html>
