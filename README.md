# Introduction

The first purpose of this script is to be a practical case for using Symfony Console and some other components. 
Then it's became a way to organize my series' directory ^^

# Install on linux

For installing this script, you will need [composer](https://getcomposer.org/doc/00-intro.md)

```
$ git clone https://github.com/PublicVar/organizer.git organizer
$ composer install
$ mv organizer/ /usr/local/bin/

```

# How to use 

## Organize the series

Keep in mind that is still under developements. For the moment you can only use it through the console.

Open a console (Ubuntu : ctrl + Alt + T).
Go to the wanted directory :
```
$ cd path/to/serie/directory
```
Launch the command 
```
$ organizer series
```

There is another to use the command by adding the directory to organize in argument : 
```
$ organizer series path/to/serie/directory
```