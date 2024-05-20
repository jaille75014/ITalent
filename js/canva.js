let canvas = document.getElementById('signatureCanva');
let ctx = canvas.getContext('2d');
let drawing = false;
let lastX = 0;
let lastY = 0;

canvas.addEventListener('mousedown', function(e) {
    drawing = true;
    lastX = e.clientX - canvas.offsetLeft;
    lastY = e.clientY - canvas.offsetTop;
});

canvas.addEventListener('mousemove', function(e) {
    if (drawing) {
        let x = e.clientX - canvas.offsetLeft;
        let y = e.clientY - canvas.offsetTop;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 1;
        ctx.stroke();
        lastX = x;
        lastY = y;
    }
});

canvas.addEventListener('mouseup', function() {
    drawing = false;
});

canvas.addEventListener('touchstart', function(e) {
    drawing = true;
    let x = e.touches[0].clientX - canvas.offsetLeft;
    let y = e.touches[0].clientY - canvas.offsetTop;
    lastX = x;
    lastY = y;
    e.preventDefault();
});

canvas.addEventListener('touchmove', function(e) {
    if (drawing) {
        let x = e.touches[0].clientX - canvas.offsetLeft;
        let y = e.touches[0].clientY - canvas.offsetTop;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 1;
        ctx.stroke();
        lastX = x;
        lastY = y;
        e.preventDefault();
    }
});

canvas.addEventListener('touchend', function() {
    drawing = false;
});

function saveSignature() {
    let dataURL = canvas.toDataURL(); 
    document.getElementById('signatureBase64').value = dataURL; 
    document.getElementById('signatureFormulaire').submit(); 
}
