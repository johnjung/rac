<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="uv/uv.css"/>
        <script src="https://unpkg.com/resize-observer-polyfill@1.5.1/dist/ResizeObserver.js"></script>
        <script type="text/javascript" src="uv/uv-assets/js/bundle.js"></script>
        <script type="text/javascript" src="uv/uv-helpers.js"></script>
        <script type="text/javascript" src="uv/uv-dist-umd/UV.js"></script>
        <title>Rose and Chess</title>
        <style>
            html, body {
                 height: 100%;
                 margin: 0;
            }   
            #uv {
                width: 100%;
                height: 100%;
            }   
        </style>
    </head>
    <body>

        <div id="uv"></div>

        <script type="text/javascript">
            // rose
            if (window.location.href.indexOf("doc=1380") !== -1) {
                var manifest_uri = "https://iiif-manifest.lib.uchicago.edu/rac/1380/rac-1380.json"; 
            } else {
                var manifest_uri = "https://iiif-manifest.lib.uchicago.edu/rac/0392/rac-0392.json";
            }
            var uv = createUV("uv", {
                manifestUri: manifest_uri,
                assetsDir: "uv/uv-assets",
                configUri: "uv-config.json"
            }, new UV.URLDataProvider());
        </script>

    </body>
</html>
