document.getElementById('stockAuto').onchange = function () {
    document.getElementById('stockMin').disabled = !this.checked;
    document.getElementById('cmdAuto').disabled = !this.checked;
};