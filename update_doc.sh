if [ "$TRAVIS_PHP_VERSION" == "5.4" ]
    then
        wget http://phpdox.de/releases/phpdox.phar
        chmod +x phpdox.phar
        php phpdox.phar
        php phpdox.phar
        git config --global user.email "travis@travis-ci.org"
        git config --global user.name "travis-ci"
        git config --global push.default simple
        git clone --quiet https://${GITHUB_TOKEN}@github.com/Nayjest/Collection.git build/gh-pages
        cd build/gh-pages
        git checkout -b gh-pages origin/gh-pages
        git rm -rf ./
        cp -Rf ../phpdox/html/* ./
        git add -f .
        git commit -m "PHPDocumentor (Travis Build: $TRAVIS_BUILD_NUMBER@$TRAVIS_TAG)"
        git push -fq origin
fi