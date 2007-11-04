#!/bin/sh

if [ "$1" = "" ]
then
{
        echo
        echo "Uso:"
        echo " reduce_foto.sh fichero.jpg"
        echo
        exit
}
fi

SALIDA="th_`basename $1`"

echo "Reduciendo $1"
convert -resize 200 "$1" "$SALIDA"
