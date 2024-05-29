## Bevezetés

A kiválasztásos rendezés (angolul Selection Sort) egy egyszerű, de hatékony rendezési algoritmus, amely iteratívan kiválasztja a legkisebb (vagy legnagyobb) elemet a rendezetlen részhalmazból, és kicseréli azt a megfelelő helyre. Az algoritmus jól alkalmazható kis méretű adatsorok rendezésére, és gyakran használják oktatási célokra az alapvető rendezési algoritmusok megértésére.

## Elméleti alapok

### Kiválasztásos rendezés működése

A kiválasztásos rendezés az adatsor elemeit két részre osztja: a rendezett és a rendezetlen részre. Kezdetben az első elem alkotja a rendezett részt, a többi elem pedig a rendezetlen részt. Az algoritmus iterál a rendezetlen részen, kiválasztja a legkisebb elemet, és kicseréli azt a rendezetlen rész első elemével. Ezután a rendezett rész egy elemmel bővül, és a rendezetlen rész egy elemmel csökken.

### Algoritmus lépései

1. Kezdjük a legelső elemtől.
2. Keressük meg a legkisebb elemet a rendezetlen részben.
3. Cseréljük ki a legkisebb elemet a rendezetlen rész első elemével.
4. Ismételjük a folyamatot a rendezetlen rész következő elemeivel, amíg az összes elem be nem kerül a rendezett részbe.

### Idő- és térbeli komplexitás

- **Időbeli komplexitás**: O(n^2) a legrosszabb, átlagos és legjobb esetben is.
- **Térbeli komplexitás**: O(1), mert csak egy kis mennyiségű extra memóriát használ.

## Gyakorlati alkalmazások

### Kis méretű adatsorok rendezése

A kiválasztásos rendezés különösen hatékony kis méretű adatsorok rendezésére, mivel az algoritmus egyszerű és kevés számú összehasonlítást végez.

### Alapvető algoritmus oktatása

Az algoritmus egyszerűsége miatt gyakran használják oktatási célokra az alapvető rendezési algoritmusok megértésére és szemléltetésére.

### Kiválasztásos rendezés implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják a kiválasztásos rendezés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>

void selectionSort(std::vector<int>& arr) {
    int n = arr.size();
    for (int i = 0; i < n - 1; ++i) {
        int minIndex = i;
        for (int j = i + 1; j < n; ++j) {
            if (arr[j] < arr[minIndex]) {
                minIndex = j;
            }
        }
        std::swap(arr[minIndex], arr[i]);
    }
}

void printArray(const std::vector<int>& arr) {
    for (int i : arr) {
        std::cout << i << " ";
    }
    std::cout << std::endl;
}

int main() {
    std::vector<int> arr = {64, 25, 12, 22, 11};
    selectionSort(arr);
    printArray(arr);
    return 0;
}
```
```java
public class SelectionSort {
    public static void selectionSort(int[] arr) {
        int n = arr.length;
        for (int i = 0; i < n - 1; ++i) {
            int minIndex = i;
            for (int j = i + 1; j < n; ++j) {
                if (arr[j] < arr[minIndex]) {
                    minIndex = j;
                }
            }
            int temp = arr[minIndex];
            arr[minIndex] = arr[i];
            arr[i] = temp;
        }
    }

    public static void printArray(int[] arr) {
        for (int i : arr) {
            System.out.print(i + " ");
        }
        System.out.println();
    }

    public static void main(String[] args) {
        int[] arr = {64, 25, 12, 22, 11};
        selectionSort(arr);
        printArray(arr);
    }
}
```
```python
def selection_sort(arr):
    n = len(arr)
    for i in range(n):
        min_index = i
        for j in range(i + 1, n):
            if arr[j] < arr[min_index]:
                min_index = j
        arr[i], arr[min_index] = arr[min_index], arr[i]

def print_array(arr):
    for i in arr:
        print(i, end=" ")
    print()

arr = [64, 25, 12, 22, 11]
selection_sort(arr)
print_array(arr)
```
```javascript
function selectionSort(arr) {
    let n = arr.length;
    for (let i = 0; i < n - 1; ++i) {
        let minIndex = i;
        for (let j = i + 1; j < n; ++j) {
            if (arr[j] < arr[minIndex]) {
                minIndex = j;
            }
        }
        [arr[minIndex], arr[i]] = [arr[i], arr[minIndex]];
    }
}

function printArray(arr) {
    console.log(arr.join(' '));
}

let arr = [64, 25, 12, 22, 11];
selectionSort(arr);
printArray(arr);
```

## Összegzés

A kiválasztásos rendezés egy egyszerű és hatékony algoritmus kis méretű adatsorok rendezésére. Az algoritmus működése könnyen érthető és implementálható, ezért gyakran használják oktatási célokra és alapvető rendezési feladatokra. Bár az időbeli komplexitása O(n^2), az egyszerűsége miatt gyakran választják alapvető rendezési feladatokra.

## További források

- [GeeksforGeeks - Selection Sort](https://www.geeksforgeeks.org/selection-sort/)
- [Wikipedia - Selection Sort](https://en.wikipedia.org/wiki/Selection_sort)
