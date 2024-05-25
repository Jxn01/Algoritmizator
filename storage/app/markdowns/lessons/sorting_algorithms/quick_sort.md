## Bevezetés

A gyorsrendezés (angolul Quick Sort) egy hatékony, széles körben használt rendezési algoritmus, amely a "divide and conquer" (oszd meg és uralkodj) elvet követi. Az algoritmus különösen jól működik nagy adatsorokon és gyakran használják a gyakorlatban az optimalizált változatait.

## Elméleti alapok

### Gyorsrendezés működése

A gyorsrendezés az adatsort úgy rendezi, hogy kiválaszt egy "pivot" elemet, és átrendezi az adatsort úgy, hogy a pivot előtti elemek kisebbek, a pivot utáni elemek pedig nagyobbak legyenek. Ezt a lépést rekurzívan alkalmazza a pivot előtti és utáni részekre is.

### Algoritmus lépései

1. Válasszunk egy pivot elemet az adatsorból.
2. Rendezjük át az elemeket úgy, hogy a pivot előtti elemek kisebbek, a pivot utáni elemek pedig nagyobbak legyenek.
3. Alkalmazzuk rekurzívan a gyorsrendezést a pivot előtti és utáni részekre.

### Idő- és térbeli komplexitás

- **Időbeli komplexitás**: Átlagosan O(n log n), legrosszabb esetben O(n^2) (például ha mindig a legkisebb vagy legnagyobb elemet választjuk pivotnak).
- **Térbeli komplexitás**: O(log n) az átlagos rekurzív verem mélység miatt.

## Gyakorlati alkalmazások

### Nagy méretű adatsorok rendezése

A gyorsrendezés különösen hatékony nagy méretű adatsorok rendezésére, mivel az átlagos időbeli komplexitása O(n log n).

### In-place rendezés

A gyorsrendezés in-place rendezési algoritmus, ami azt jelenti, hogy nem igényel jelentős kiegészítő memóriát az adatok rendezéséhez, ezáltal memóriahatékony.

### Gyorsrendezés implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják a gyorsrendezés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>

void swap(int& a, int& b) {
    int temp = a;
    a = b;
    b = temp;
}

int partition(std::vector<int>& arr, int low, int high) {
    int pivot = arr[high];
    int i = low - 1;

    for (int j = low; j <= high - 1; ++j) {
        if (arr[j] < pivot) {
            ++i;
            swap(arr[i], arr[j]);
        }
    }
    swap(arr[i + 1], arr[high]);
    return (i + 1);
}

void quickSort(std::vector<int>& arr, int low, int high) {
    if (low < high) {
        int pi = partition(arr, low, high);

        quickSort(arr, low, pi - 1);
        quickSort(arr, pi + 1, high);
    }
}

void printArray(const std::vector<int>& arr) {
    for (int i : arr) {
        std::cout << i << " ";
    }
    std::cout << std::endl;
}

int main() {
    std::vector<int> arr = {10, 7, 8, 9, 1, 5};
    quickSort(arr, 0, arr.size() - 1);
    printArray(arr);
    return 0;
}
```
```java
public class QuickSort {
    static void swap(int[] arr, int i, int j) {
        int temp = arr[i];
        arr[i] = arr[j];
        arr[j] = temp;
    }

    static int partition(int[] arr, int low, int high) {
        int pivot = arr[high];
        int i = (low - 1);
        for (int j = low; j <= high - 1; j++) {
            if (arr[j] < pivot) {
                i++;
                swap(arr, i, j);
            }
        }
        swap(arr, i + 1, high);
        return (i + 1);
    }

    static void quickSort(int[] arr, int low, int high) {
        if (low < high) {
            int pi = partition(arr, low, high);

            quickSort(arr, low, pi - 1);
            quickSort(arr, pi + 1, high);
        }
    }

    static void printArray(int[] arr) {
        for (int i : arr) {
            System.out.print(i + " ");
        }
        System.out.println();
    }

    public static void main(String[] args) {
        int[] arr = {10, 7, 8, 9, 1, 5};
        quickSort(arr, 0, arr.length - 1);
        printArray(arr);
    }
}
```
```python
def swap(arr, i, j):
    arr[i], arr[j] = arr[j], arr[i]

def partition(arr, low, high):
    pivot = arr[high]
    i = low - 1
    for j in range(low, high):
        if arr[j] < pivot:
            i += 1
            swap(arr, i, j)
    swap(arr, i + 1, high)
    return i + 1

def quick_sort(arr, low, high):
    if low < high:
        pi = partition(arr, low, high)
        quick_sort(arr, low, pi - 1)
        quick_sort(arr, pi + 1, high)

def print_array(arr):
    for i in arr:
        print(i, end=" ")
    print()

arr = [10, 7, 8, 9, 1, 5]
quick_sort(arr, 0, len(arr) - 1)
print_array(arr)
```
```javascript
function swap(arr, i, j) {
    [arr[i], arr[j]] = [arr[j], arr[i]];
}

function partition(arr, low, high) {
    let pivot = arr[high];
    let i = low - 1;
    for (let j = low; j <= high - 1; j++) {
        if (arr[j] < pivot) {
            i++;
            swap(arr, i, j);
        }
    }
    swap(arr, i + 1, high);
    return i + 1;
}

function quickSort(arr, low, high) {
    if (low < high) {
        let pi = partition(arr, low, high);
        quickSort(arr, low, pi - 1);
        quickSort(arr, pi + 1, high);
    }
}

function printArray(arr) {
    console.log(arr.join(' '));
}

let arr = [10, 7, 8, 9, 1, 5];
quickSort(arr, 0, arr.length - 1);
printArray(arr);
```

## Összegzés

A gyorsrendezés egy hatékony, in-place rendezési algoritmus, amely különösen jól működik nagy méretű adatsorokon. Az algoritmus átlagos időbeli komplexitása O(n log n), de a legrosszabb esetben O(n^2) lehet. Az algoritmus használata széles körben elterjedt a gyakorlatban, különösen akkor, ha optimalizált változatokat alkalmaznak.

## További források

- [GeeksforGeeks - Quick Sort](https://www.geeksforgeeks.org/quick-sort/)
- [Wikipedia - Quick Sort](https://en.wikipedia.org/wiki/Quicksort)
