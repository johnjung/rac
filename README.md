# Installing this site

Build a copy of this site, and start it in a docker container:

```console
git clone https://github.com/johnjung/rac.git
docker build -t rac .
docker run --rm -it -p 8080:8080 rac 
```
