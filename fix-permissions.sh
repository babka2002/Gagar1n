#!/bin/bash

# ��п�авленн�й �к�ип� дл� ва�его �е�ве�а
SITE_ROOT="/var/www/www-root/data/www/gagar1n.ru"
WEB_USER="www-root"
WEB_GROUP="www-root"

echo "�а���ойка п�ав до���па дл� Statamic..."
echo "Сай�: $SITE_ROOT"
echo "�ол�зова�ел�: $WEB_USER:$WEB_GROUP"

cd $SITE_ROOT

# ��новн�е п�ава
echo "У��анавливаем о�новн�е п�ава..."
chown -R $WEB_USER:$WEB_GROUP .

# �азов�е п�ава: 664 дл� �айлов, 775 дл� папок
find . -type f -exec chmod 664 {} \;
find . -type d -exec chmod 775 {} \;

# У��анавливаем setgid дл� папок (на�ледование г��пп�)
find . -type d -exec chmod g+s {} \;

# ��и�и�е�ки важн�е ди�ек�о�ии дл� Statamic
echo "�а���ойка �пе�иал�н�� ди�ек�о�ий..."
directories=(
    "storage"
    "storage/logs"
    "storage/statamic"
    "storage/statamic/glide"
    "storage/statamic/stache-locks"
    "bootstrap/cache"
    "public/assets"
    "content"
    "resources/blueprints"
    "resources/views"
)

for dir in "${directories[@]}"; do
    if [ -d "$dir" ]; then
        echo "�а���ойка п�ав дл�: $dir"
        chmod -R 775 "$dir"
        chown -R $WEB_USER:$WEB_GROUP "$dir"
    else
        echo "��ед�п�еждение: �и�ек�о�и� $dir не найдена"
    fi
done

# Спе�иал�н�е п�ава дл� и�полн�ем�� �айлов
if [ -f "artisan" ]; then
    chmod 755 artisan
fi

echo "� ��ава до���па на���оен� ��пе�но!"
echo ""
echo "��ове�ка кл��ев�� папок:"
ls -la storage/logs/ 2>/dev/null | head -2
ls -la storage/statamic/stache-locks/ 2>/dev/null | head -2
ls -la public/assets/ 2>/dev/null | head -2

echo ""
echo "�л� п�ове�ки PHP-FPM п�ла в�полни�е:"
echo "ps aux | grep 'pool gagar1n.ru' | grep -v grep"