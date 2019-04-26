# semantic-ui-css-offline
## Semantic-UI Version 2.4.2
semantic-ui-css-offline package provides Semantic UI CSS style sheet and static files, like fonts and icons.
It uses gulp to download and build the newest version of CSS. Additionally modifies build settings of Semantic UI to turn off google fonts and adds a newer version of Loto font, to support offline usage and better unicode character support.

It was created to use with "Semantic UI React" inside "create-react-app". It should work with any configuration if your module bundler have proper support.


## install latest

```npm install --save semantic-ui-css-offline```



##  install a specific version
```bash
npm install --save semantic-ui-css-offline@1.0.4-2.4.2 #2.4.2
npm install --save semantic-ui-css-offline@1.0.3-2.4.1 #2.4.1
npm install --save semantic-ui-css-offline@1.0.1-2.3.3 #2.3.3
npm install --save semantic-ui-css-offline@1.0.1-2.3.2 #2.3.2
```


## usage in module bundler (Like Webpack)

At the top level of your project
```JavaScript
import 'semantic-ui-css-offline'
```


##  Do you want newer version of Semantic-UI?

* clone repo
* run ```npm install gulp -g```
* run ```npm install```
* run ```gulp```
* Use foulders ```fonts``` ```themes``` and file ```semantic.min.css``` for your project.


License
----

MIT
