# \B2U\Core\Utility

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

# Methods
```PHP
\B2U\Core\Utility::getFromGet($paramName, $defaultValue = "")
```
##
```PHP
\B2U\Core\Utility::getFromPost($paramName, $defaultValue = "")
```
##
```PHP
\B2U\Core\Utility::getParam($paramName, $defaultValue = "")
```
##
```PHP
\B2U\Core\Utility::getSession($paramName, $defaultValue = "")
```
##
```PHP
\B2U\Core\Utility::getCookie($paramName, $defaultValue = "")
```
##
```PHP
\B2U\Core\Utility::getDomain()
```
##
```PHP
\B2U\Core\Utility::getClientIP()
```
##
```PHP
\B2U\Core\Utility::isHTTPS()
```
##
```PHP
\B2U\Core\Utility::sanitize(array &$data, $filter = false)
```
##
```PHP
\B2U\Core\Utility::fileGetContentsUtf8($fn)
```
##
```PHP
\B2U\Core\Utility::rrmdir($dir)
```
##
```PHP
\B2U\Core\Utility::stdExec($cmd, &$stdout=null, &$stderr=null)
```
##
```PHP
\B2U\Core\Utility::isAjax()
```
##
```PHP
\B2U\Core\Utility::copyDir($from, $to)
```
##
```PHP
\B2U\Core\Utility::getFiles($dir, $ext = null)
```
##
```PHP
\B2U\Core\Utility::getAbsolutePath($path)
```
##
```PHP
\B2U\Core\Utility::validateRoot($root, $path)
```
##
```PHP
\B2U\Core\Utility::isJson($string)
```
##
```PHP
\B2U\Core\Utility::convertToDataJSON($array)
```
##
```PHP
\B2U\Core\Utility::convertToObject($array)
```
##
```PHP
\B2U\Core\Utility::recursiveDecode($json, &$output)
```
##
```PHP
\B2U\Core\Utility::shuffleArray($ary)
```
##
```PHP
\B2U\Core\Utility::randomDigits($Num = 6)
```
##
```PHP
// @param $simple - setting this flag will remove the 0OI from the list
\B2U\Core\Utility::randomAlphaNumString($Num = 8, $simple = false)
```
##
```PHP
\B2U\Core\Utility::randomPassword($Num = 8, $Complex = false)
```
##
```PHP
\B2U\Core\Utility::uniqidReal($lenght = 13)
```
##
```PHP
\B2U\Core\Utility::guidv4()
```
##
```PHP
// @param $flag - an array where the key can be one of 
// image, office, text, video, audio, and pdf and if a
// key is present in the list it will indicate that it
// is an invalid file type. empty $flag allows all.
\B2U\Core\Utility::validateFileUpload($file, $flag, $tmp_name = "tmp_name")
```
##
```PHP
\B2U\Core\Utility::email($from, $to, $cc, $subject, $message)
```
##
```PHP
// if $ext is provided the actual file is ignored
\B2U\Core\Utility::getExtMime($file, $ext = null)
```
##

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_UTILITY.md#b2ucoreutility)
