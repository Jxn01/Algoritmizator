## Bevezetés

A beszúró rendezés (angolul Insertion Sort) egy egyszerű és hatékony rendezési algoritmus, amely különösen jól működik kis méretű vagy részben rendezett adatsorokon. Az algoritmus azon az elven alapul, hogy az elemeket egyesével rendezi be egy már rendezett részhalmazba, így fokozatosan növeli a rendezett elemek számát.

## Elméleti alapok

### Beszúró rendezés működése

A beszúró rendezés az adatsort két részre osztja: a rendezett és a rendezetlen részre. Kezdetben az első elem alkotja a rendezett részt, a többi elem pedig a rendezetlen részt. Az algoritmus iterál a rendezetlen részen, és minden egyes elemét beilleszti a megfelelő helyre a rendezett részben.

### Algoritmus lépései

1. Induljunk a második elemtől (mivel az első elemet egy elemű rendezett résznek tekintjük).
2. Az aktuális elemet hasonlítsuk össze a rendezett rész elemeivel, és helyezzük be a megfelelő helyre.
3. Ismételjük, amíg az összes elem be nem kerül a rendezett részbe.

### Idő- és térbeli komplexitás

- **Időbeli komplexitás**: O(n^2) a legrosszabb és átlagos esetben, O(n) a legjobb esetben (ha az adatsor már rendezett).
- **Térbeli komplexitás**: O(1), mert csak egy kis mennyiségű extra memóriát használ.

## Gyakorlati alkalmazások

### Kis méretű adatsorok rendezése

A beszúró rendezés különösen hatékony kis méretű adatsorok rendezésére, mivel az algoritmus egyszerű és kevés számú összehasonlítást végez.

### Részben rendezett adatsorok

A beszúró rendezés hatékony részben rendezett adatsorok esetén, mivel az ilyen esetekben az algoritmus kevés mozgást igényel az elemek között.

### Beszúró rendezés implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják a beszúró rendezés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>

void insertionSort(std::vector<int>& arr) {
    int n = arr.size();
    for (int i = 1; i < n; ++i) {
        int key = arr[i];
        int j = i - 1;
        while (j >= 0 && arr[j] > key) {
            arr[j + 1] = arr[j];
            --j;
        }
        arr[j + 1] = key;
    }
}

void printArray(const std::vector<int>& arr) {
    for (int i : arr) {
        std::cout << i << " ";
    }
    std::cout << std::endl;
}

int main() {
    std::vector<int> arr = {12, 11, 13, 5, 6};
    insertionSort(arr);
    printArray(arr);
    return 0;
}
```
```java
public class InsertionSort {
    public static void insertionSort(int[] arr) {
        int n = arr.length;
        for (int i = 1; i < n; ++i) {
            int key = arr[i];
            int j = i - 1;
            while (j >= 0 && arr[j] > key) {
                arr[j + 1] = arr[j];
                j = j - 1;
            }
            arr[j + 1] = key;
        }
    }

    public static void printArray(int[] arr) {
        for (int i : arr) {
            System.out.print(i + " ");
        }
        System.out.println();
    }

    public static void main(String[] args) {
        int[] arr = {12, 11, 13, 5, 6};
        insertionSort(arr);
        printArray(arr);
    }
}
```
```python
def insertion_sort(arr):
    for i in range(1, len(arr)):
        key = arr[i]
        j = i - 1
        while j >= 0 and key < arr[j]:
            arr[j + 1] = arr[j]
            j -= 1
        arr[j + 1] = key

def print_array(arr):
    for i in arr:
        print(i, end=" ")
    print()

arr = [12, 11, 13, 5, 6]
insertion_sort(arr)
print_array(arr)
```
```javascript
function insertionSort(arr) {
    let n = arr.length;
    for (let i = 1; i < n; ++i) {
        let key = arr[i];
        let j = i - 1;
        while (j >= 0 && arr[j] > key) {
            arr[j + 1] = arr[j];
            j = j - 1;
        }
        arr[j + 1] = key;
    }
}

function printArray(arr) {
    console.log(arr.join(' '));
}

let arr = [12, 11, 13, 5, 6];
insertionSort(arr);
printArray(arr);
```

## Összegzés

A beszúró rendezés egy egyszerű és hatékony algoritmus kis méretű vagy részben rendezett adatsorok rendezésére. Az algoritmus működése könnyen érthető és implementálható, ezért gyakran használják oktatási célokra és alapvető rendezési feladatokra. Bár az időbeli komplexitása O(n^2), bizonyos esetekben, mint például kis vagy részben rendezett adatsorok, nagyon hatékony lehet.

## További források

- [GeeksforGeeks - Insertion Sort](https://www.geeksforgeeks.org/insertion-sort/)
- [Wikipedia - Insertion Sort](https://en.wikipedia.org/wiki/Insertion_sort)
