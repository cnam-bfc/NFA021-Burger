$(function () {


    document.getElementById('stockAuto').onchange = function () {
        document.getElementById('qteMin').disabled = !this.checked;
        document.getElementById('qteStandard').disabled = !this.checked;
    };

});
