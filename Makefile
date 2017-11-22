version = 1.0.0

all: release artifact svn
PHONY: all

release:
	rm -rf ./build/release/
	mkdir -p ./build/release/

	rsync -rhLDvzP --exclude=.DS_Store --delete ./trunk/ ./build/release/trunk/

	rm -rfv ./build/release/trunk/lib/.codeclimate.yml \
		./build/release/trunk/lib/.git \
		./build/release/trunk/lib/.gitattributes \
		./build/release/trunk/lib/.gitignore \
		./build/release/trunk/lib/.styleci.yml \
		./build/release/trunk/lib/.travis.yml \
		./build/release/trunk/lib/CONTRIBUTING.md \
    	./build/release/trunk/lib/LICENSE.md \
    	./build/release/trunk/lib/README.md \
    	./build/release/trunk/lib/composer.json \
    	./build/release/trunk/lib/docs \
    	./build/release/trunk/lib/phpdoc.xml \
    	./build/release/trunk/lib/phpunit.xml \
    	./build/release/trunk/lib/tests

	rsync -rhLDvzP --exclude=.DS_Store --delete ./assets/ ./build/release/assets/

	rm -rfv ./build/release/trunk/languages/.git \
		./build/release/trunk/languages/.gitignore

artifact: release
	rm -rvf ./build/artifacts/wp-security-txt-v$(version).zip
	mkdir -p ./build/artifacts/
	rm -rvf ./wp-security-txt/
	cp -pRv ./build/release/trunk/ ./wp-security-txt/
	zip -r9 wp-security-txt-v$(version).zip wp-security-txt
	mv -v ./wp-security-txt-v$(version).zip ./build/artifacts/wp-security-txt-v$(version).zip
	rm -rvf ./wp-security-txt/

svn: artifact
	rsync -rhLDvzP --delete ./build/release/trunk/ ../wordpress-security-txt-svn/trunk/
	rsync -rhLDvzP --delete ./build/release/assets/ ../wordpress-security-txt-svn/assets/
