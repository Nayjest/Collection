wget http://phpdox.de/releases/phpdox.phar
chmod +x phpdox.phar
php phpdox.phar
git config --global user.email "travis@travis-ci.org"
git config --global user.name "travis-ci"
git clone --quiet https://${GITHUB_TOKEN}@github.com/Nayjest/Collection.git build/gh-pages
cd build/gh-pages
git checkout -b gh-pages origin/gh-pages
git rm -rf ./
cp -Rf ../phpdox/html/* ./
git add -f .
git commit -m "PHPDocumentor (Travis Build: $TRAVIS_BUILD_NUMBER@$TRAVIS_TAG)"
git push -fq origin