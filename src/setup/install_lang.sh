for lang in "$@"
do
    echo -e "\n[Installing language pack for Moodle: ${lang}]"
    target="/harpia/data/moodledata/lang/${lang}.zip"
    curl -L https://download.moodle.org/download.php/direct/langpack/4.5/${lang}.zip -o "$target"
    unzip "$target" -d "/harpia/data/moodledata/lang/"
    rm "$target"
done
