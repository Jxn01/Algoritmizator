## Bevezetés

A tömbök (angolul arrays) az adatszerkezetek egy alapvető típusa, amely azonos típusú elemek rögzített számú sorozatát tárolja. Az adatok hatékony tárolása és kezelése érdekében elengedhetetlen a tömbök alapos ismerete. Ez a lecke részletesen bemutatja a tömbök elméleti alapjait és gyakorlati alkalmazásait különböző programozási nyelveken.

## Elméleti alapok

### Tömb definíciója

A tömb egy olyan adatszerkezet, amely azonos típusú elemek rögzített hosszúságú sorozatát tartalmazza. Az elemek elérése indexek segítségével történik, amelyek általában 0-tól kezdődnek.

### Tömbök jellemzői

- **Indexelés**: Az elemek indexekkel érhetők el. Az indexek általában 0-tól kezdődnek.
- **Méret**: A tömb mérete rögzített és a létrehozáskor kerül meghatározásra.
- **Homogenitás**: Az elemek azonos típusúak.
- **Memóriaelhelyezés**: Az elemek a memóriában lineárisan helyezkednek el.

### Tömbök memóriakezelése

A tömbök memóriakezelése egyszerű, mivel az elemek lineárisan helyezkednek el a memóriában. Ez gyors hozzáférést biztosít az egyes elemekhez, mivel az elemek közötti távolság a memóriában állandó, ami lehetővé teszi az O(1) idejű hozzáférést.

## Tömbök gyakorlati alkalmazásai

### Egyszerű tömb létrehozása és kezelése

A következő kódpéldák bemutatják, hogyan lehet létrehozni és kezelni egyszerű tömböket különböző programozási nyelveken.

```cpp
#include <iostream>

int main() {
    int arr[5] = {1, 2, 3, 4, 5};
    for (int i = 0; i < 5; i++) {
        std::cout << arr[i] << " ";
    }
    return 0;
}
```
```java
public class Main {
    public static void main(String[] args) {
        int[] arr = {1, 2, 3, 4, 5};
        for (int i = 0; i < arr.length; i++) {
            System.out.print(arr[i] + " ");
        }
    }
}
```
```python
arr = [1, 2, 3, 4, 5]
for i in arr:
    print(i, end=" ")
```
```javascript
let arr = [1, 2, 3, 4, 5];
for (let i = 0; i < arr.length; i++) {
    console.log(arr[i]);
}
```

### Tömbök módosítása és elem hozzáférés

A következő példák bemutatják, hogyan lehet módosítani a tömbök elemeit és hozzáférni azokhoz.

```cpp
#include <iostream>

int main() {
    int arr[5] = {1, 2, 3, 4, 5};
    arr[2] = 10;  // Módosítja a harmadik elemet
    std::cout << arr[2];  // Kiírja a harmadik elemet
    return 0;
}
```
```java
public class Main {
    public static void main(String[] args) {
        int[] arr = {1, 2, 3, 4, 5};
        arr[2] = 10;  // Módosítja a harmadik elemet
        System.out.println(arr[2]);  // Kiírja a harmadik elemet
    }
}
```
```python
arr = [1, 2, 3, 4, 5]
arr[2] = 10  # Módosítja a harmadik elemet
print(arr[2])  # Kiírja a harmadik elemet
```
```javascript
let arr = [1, 2, 3, 4, 5];
arr[2] = 10;  // Módosítja a harmadik elemet
console.log(arr[2]);  // Kiírja a harmadik elemet
```

### Tömbök haladó használata

#### Tömbök rendezése

A tömbök rendezése gyakori művelet, amely számos algoritmussal megvalósítható. Az alábbiakban a beépített rendezési függvényeket használjuk.

```cpp
#include <iostream>
#include <algorithm>

int main() {
    int arr[5] = {5, 3, 4, 1, 2};
    std::sort(arr, arr + 5);
    for (int i = 0; i < 5; i++) {
        std::cout << arr[i] << " ";
    }
    return 0;
}
```
```java
import java.util.Arrays;

public class Main {
    public static void main(String[] args) {
        int[] arr = {5, 3, 4, 1, 2};
        Arrays.sort(arr);
        for (int i : arr) {
            System.out.print(i + " ");
        }
    }
}
```
```python
arr = [5, 3, 4, 1, 2]
arr.sort()
print(arr)
```
```javascript
let arr = [5, 3, 4, 1, 2];
arr.sort((a, b) => a - b);
console.log(arr);
```

### Többdimenziós tömbök

A többdimenziós tömbök olyan tömbök, amelyek tömböket tartalmaznak. Az alábbi példákban kétdimenziós tömböket hozunk létre és kezelünk.

```cpp
#include <iostream>

int main() {
    int arr[2][3] = {{1, 2, 3}, {4, 5, 6}};
    for (int i = 0; i < 2; i++) {
        for (int j = 0; j < 3; j++) {
            std::cout << arr[i][j] << " ";
        }
        std::cout << std::endl;
    }
    return 0;
}
```
```java
public class Main {
    public static void main(String[] args) {
        int[][] arr = {{1, 2, 3}, {4, 5, 6}};
        for (int i = 0; i < arr.length; i++) {
            for (int j = 0; j < arr[i].length; j++) {
                System.out.print(arr[i][j] + " ");
            }
            System.out.println();
        }
    }
}
```
```python
arr = [[1, 2, 3], [4, 5, 6]]
for row in arr:
    for elem in row:
        print(elem, end=" ")
    print()
```
```javascript
let arr = [
    [1, 2, 3],
    [4, 5, 6]
];
for (let i = 0; i < arr.length; i++) {
    for (let j = 0; j < arr[i].length; j++) {
        console.log(arr[i][j]);
    }
}
```

## Összegzés

A tömbök alapvető adatszerkezetek, amelyek hatékony adatkezelést és gyors hozzáférést biztosítanak. A fenti példák bemutatják a tömbök különböző nyelveken való használatát, a legegyszerűbb műveletektől a haladóbb technikákig. A tömbök ismerete elengedhetetlen a programozási készségek fejlesztéséhez és a komplex problémák megoldásához.

## További források

- [GeeksforGeeks - Arrays](https://www.geeksforgeeks.org/array-data-structure/)
- [Wikipedia - Array data structure](https://en.wikipedia.org/wiki/Array_data_structure)
