# Picross Web

### About
I really, really, **_REALLY_** love picross. It is almost an unhealthy habit of mine. So I decided to try and create a platform where people could play and create picross puzzles online for everyone else to enjoy.

I created this using mostly jQuery and some PHP where I needed to manipulate and create/edit files for the puzzles.

Still need to find a place to host this, though. =P

**PS:** If you are cloning this repository and want only puzzle files inside of their respective folders, don't forget to remove the `.gitignore` files from each of the `stages` folders and change the loop inside line **36** of the `one_size` function on `list.php` like this:

```diff
- if(($file[$i] != ".") && ($file[$i] != "..") && ($file[$i] != ".gitignore")){
+ if(($file[$i] != ".") && ($file[$i] != "..")){
```