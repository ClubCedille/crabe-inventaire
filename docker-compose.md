# Composer is used to manage this project. 

To use composer in this directory, simply use this command:

```
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --user $(id -u):$(id -g) \
  composer bash
```

This will load a shell and mount the current directory as a volume in the container

