## Bevezetés

Az összefésüléses rendezés (angolul Merge Sort) egy hatékony, stabil, rendezési algoritmus, amelynek időbeli komplexitása O(n log n). Az algoritmus a "divide and conquer" (oszd meg és uralkodj) elvet követi, azaz az adatsort kisebb részekre bontja, majd azokat rendezi és összefésüli. Az összefésüléses rendezés különösen jól működik nagy méretű adatsorok esetén.

## Elméleti alapok

### Összefésüléses rendezés működése

Az összefésüléses rendezés két fő lépésből áll:
1. **Felbontás**: Az adatsort addig bontjuk két részre, amíg minden rész egyetlen elemet tartalmaz.
2. **Összefésülés**: Az egy elemből álló részeket fokozatosan összeillesztjük és rendezzük, amíg vissza nem kapjuk az eredeti adatsor teljes rendezett változatát.

### Algoritmus lépései

1. Ha az adatsor mérete 1 vagy kisebb, akkor az már rendezett.
2. Osszuk az adatsort két részre.
3. Alkalmazzuk rekurzívan az összefésüléses rendezést a két részre.
4. Fésüljük össze a két rendezett részt egy rendezett adatsorrá.

### Idő- és térbeli komplexitás

- **Időbeli komplexitás**: O(n log n) a legrosszabb, átlagos és legjobb esetben is.
- **Térbeli komplexitás**: O(n), mivel szükség van kiegészítő memóriára az összefésülés során.

## Gyakorlati alkalmazások

### Nagy méretű adatsorok rendezése

Az összefésüléses rendezés különösen hatékony nagy méretű adatsorok rendezésére, mivel az időbeli komplexitása O(n log n), ami jobb, mint a buborékos és kiválasztásos rendezés O(n^2) komplexitása.

### Stabil rendezés

Az összefésüléses rendezés stabil rendezési algoritmus, azaz nem változtatja meg az egyenlő értékű elemek sorrendjét. Ez fontos lehet olyan alkalmazásoknál, ahol az adatok eredeti sorrendje jelentőséggel bír.

### Összefésüléses rendezés implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják az összefésüléses rendezés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>

void merge(std::vector<int>& arr, int left, int mid, int right) {
    int n1 = mid - left + 1;
    int n2 = right - mid;

    std::vector<int> L(n1), R(n2);

    for (int i = 0; i < n1; ++i)
        L[i] = arr[left + i];
    for (int j = 0; j < n2; ++j)
        R[j] = arr[mid + 1 + j];

    int i = 0, j = 0, k = left;
    while (i < n1 && j < n2) {
        if (L[i] <= R[j]) {
            arr[k] = L[i];
            ++i;
        } else {
            arr[k] = R[j];
            ++j;
        }
        ++k;
    }

    while (i < n1) {
        arr[k] = L[i];
        ++i;
        ++k;
    }

    while (j < n2) {
        arr[k] = R[j];
        ++j;
        ++k;
    }
}

void mergeSort(std::vector<int>& arr, int left, int right) {
    if (left < right) {
        int mid = left + (right - left) / 2;
        mergeSort(arr, left, mid);
        mergeSort(arr, mid + 1, right);
        merge(arr, left, mid, right);
    }
}

void printArray(const std::vector<int>& arr) {
    for (int i : arr) {
        std::cout << i << " ";
    }
    std::cout << std::endl;
}

int main() {
    std::vector<int> arr = {12, 11, 13, 5, 6, 7};
    mergeSort(arr, 0, arr.size() - 1);
    printArray(arr);
    return 0;
}
```
```java
public class MergeSort {
    void merge(int arr[], int left, int mid, int right) {
        int n1 = mid - left + 1;
        int n2 = right - mid;

        int L[] = new int[n1];
        int R[] = new int[n2];

        for (int i = 0; i < n1; ++i)
            L[i] = arr[left + i];
        for (int j = 0; j < n2; ++j)
            R[j] = arr[mid + 1 + j];

        int i = 0, j = 0, k = left;
        while (i < n1 && j < n2) {
            if (L[i] <= R[j]) {
                arr[k] = L[i];
                ++i;
            } else {
                arr[k] = R[j];
                ++j;
            }
            ++k;
        }

        while (i < n1) {
            arr[k] = L[i];
            ++i;
            ++k;
        }

        while (j < n2) {
            arr[k] = R[j];
            ++j;
            ++k;
        }
    }

    void mergeSort(int arr[], int left, int right) {
        if (left < right) {
            int mid = left + (right - left) / 2;
            mergeSort(arr, left, mid);
            mergeSort(arr, mid + 1, right);
            merge(arr, left, mid, right);
        }
    }

    static void printArray(int arr[]) {
        for (int i : arr) {
            System.out.print(i + " ");
        }
        System.out.println();
    }

    public static void main(String args[]) {
        int arr[] = {12, 11, 13, 5, 6, 7};
        MergeSort ob = new MergeSort();
        ob.mergeSort(arr, 0, arr.length - 1);
        printArray(arr);
    }
}
```
```python
def merge(arr, left, mid, right):
    n1 = mid - left + 1
    n2 = right - mid

    L = [0] * n1
    R = [0] * n2

    for i in range(0, n1):
        L[i] = arr[left + i]
    for j in range(0, n2):
        R[j] = arr[mid + 1 + j]

    i = 0
    j = 0
    k = left

    while i < n1 and j < n2:
        if L[i] <= R[j]:
            arr[k] = L[i]
            i += 1
        else:
            arr[k] = R[j]
            j += 1
        k += 1

    while i < n1:
        arr[k] = L[i]
        i += 1
        k += 1

    while j < n2:
        arr[k] = R[j]
        j += 1
        k += 1

def merge_sort(arr, left, right):
    if left < right:
        mid = (left + right) // 2
        merge_sort(arr, left, mid)
        merge_sort(arr, mid + 1, right)
        merge(arr, left, mid, right)

def print_array(arr):
    for i in arr:
        print(i, end=" ")
    print()

arr = [12, 11, 13, 5, 6, 7]
merge_sort(arr, 0, len(arr) - 1)
print_array(arr)
```
```javascript
function merge(arr, left, mid, right) {
    let n1 = mid - left + 1;
    let n2 = right - mid;

    let L = new Array(n1);
    let R = new Array(n2);

    for (let i = 0; i < n1; i++)
        L[i] = arr[left + i];
    for (let j = 0; j < n2; j++)
        R[j] = arr[mid + 1 + j];

    let i = 0, j = 0, k = left;
    while (i < n1 && j < n2) {
        if (L[i] <= R[j]) {
            arr[k] = L[i];
            i++;
        } else {
            arr[k] = R[j];
            j++;
        }
        k++;
    }

    while (i < n1) {
        arr[k] = L[i];
        i++;
        k++;
    }

    while (j < n2) {
        arr[k] = R[j];
        j++;
        k++;
    }
}

function mergeSort(arr, left, right) {
    if (left < right) {
        let mid = Math.floor((left + right) / 2);
        mergeSort(arr, left, mid);
        mergeSort(arr, mid + 1, right);
        merge(arr, left, mid, right);
    }
}

function printArray(arr) {
    console.log(arr.join(' '));
}

let arr = [12, 11, 13, 5, 6, 7];
mergeSort(arr, 0, arr.length - 1);
printArray(arr);
```

## Összegzés

Az összefésüléses rendezés egy hatékony és stabil rendezési algoritmus, amely különösen jól működik nagy méretű adatsorok rendezésére. Az algoritmus működése könnyen érthető és implementálható, és időbeli komplexitása O(n log n) a legrosszabb esetben is. Az összefésüléses rendezés gyakran alkalmazható különböző gyakorlati problémák megoldására, ahol hatékony és stabil rendezés szükséges.

## További források

- [GeeksforGeeks - Merge Sort](https://www.geeksforgeeks.org/merge-sort/)
- [Wikipedia - Merge Sort](https://en.wikipedia.org/wiki/Merge_sort)
