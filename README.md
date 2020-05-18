# Installing this site

To install a development version of this site, start by building a copy of the
Universal Viewer:

```console
git clone https://github.com/UniversalViewer/universalviewer.git
cd universalviewer
git checkout webpack
npm install grunt
npm audit fix 
npm run build
```

Save the path to the dist directory so you can symlink to it later:

```console
cd dist
pwd dist
```

Build a copy of this site, and start it in a docker container:

```console
git clone https://github.com/johnjung/rac.git
cd rac 
cd web 
ln -s dist uv
ln -s dist/uv-dist-umd uv-dist-umd

cd ..
docker build -t rac .
docker run --rm -it -p 8080:8080 rac 
```
