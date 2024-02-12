<script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('qrcodeScanner') });
    scanner.addListener('scan', function (content) {
        console.log(content);
        document.getElementById('productionPlotCode').value = content
    });
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);
    });
</script>