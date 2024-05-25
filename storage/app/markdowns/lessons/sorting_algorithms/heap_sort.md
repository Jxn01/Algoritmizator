## Bevezetés

A kupacrendezés (angolul Heap Sort) egy hatékony és stabil rendezési algoritmus, amely a maximális vagy minimális kupac (heap) adatstruktúrára épül. Az algoritmus két fő lépésből áll: a bemeneti adatsor kupaccá alakítása és a kupac rendezése. A kupacrendezés egy in-place algoritmus, amely nem igényel extra memóriát az adatok rendezéséhez.

## Elméleti alapok

### Kupac

A kupac egy teljes bináris fa, amely megfelel a kupac tulajdonságának:
- **Max-kupac**: Minden csomópont értéke nagyobb vagy egyenlő, mint a gyerekeinek értéke.
- **Min-kupac**: Minden csomópont értéke kisebb vagy egyenlő, mint a gyerekeinek értéke.

### Kupacrendezés működése

A kupacrendezés az adatsort úgy rendezi, hogy először kupaccá alakítja, majd fokozatosan eltávolítja a kupacból a legnagyobb (vagy legkisebb) elemet, és a megfelelő helyre teszi azt.

### Algoritmus lépései

1. Építsünk egy max-kupacot a bemeneti adatsorból.
2. Cseréljük ki a max-kupac gyökerét az utolsó elemmel, és csökkentsük a kupac méretét.
3. Alkalmazzuk a kupac tulajdonságainak helyreállítását a gyökéren.
4. Ismételjük, amíg a kupac mérete egy nem lesz.

### Idő- és térbeli komplexitás

- **Időbeli komplexitás**: O(n log n) a legrosszabb, átlagos és legjobb esetben is.
- **Térbeli komplexitás**: O(1), mivel in-place algoritmus.

## Gyakorlati alkalmazások

### Nagy méretű adatsorok rendezése

A kupacrendezés különösen hatékony nagy méretű adatsorok rendezésére, mivel az időbeli komplexitása O(n log n) és nem igényel extra memóriát.

### Stabil rendezés

A kupacrendezés stabil rendezési algoritmus, amely megőrzi az egyenlő értékű elemek sorrendjét, ami fontos lehet bizonyos alkalmazásoknál.

### Kupacrendezés implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják a kupacrendezés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>

void heapify(std::vector<int>& arr, int n, int i) {
    int largest = i;
    int left = 2 * i + 1;
    int right = 2 * i + 2;

    if (left < n && arr[left] > arr[largest])
        largest = left;

    if (right < n && arr[right] > arr[largest])
        largest = right;

    if (largest != i) {
        std::swap(arr[i], arr[largest]);
        heapify(arr, n, largest);
    }
}

void heapSort(std::vector<int>& arr) {
    int n = arr.size();

    for (int i = n / 2 - 1; i >= 0; i--)
        heapify(arr, n, i);

    for (int i = n - 1; i > 0; i--) {
        std::swap(arr[0], arr[i]);
        heapify(arr, i, 0);
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
    heapSort(arr);
    printArray(arr);
    return 0;
}
```
```java
public class HeapSort {
    public void heapify(int arr[], int n, int i) {
        int largest = i;
        int left = 2 * i + 1;
        int right = 2 * i + 2;

        if (left < n && arr[left] > arr[largest])
            largest = left;

        if (right < n && arr[right] > arr[largest])
            largest = right;

        if (largest != i) {
            int swap = arr[i];
            arr[i] = arr[largest];
            arr[largest] = swap;

            heapify(arr, n, largest);
        }
    }

    public void heapSort(int arr[]) {
        int n = arr.length;

        for (int i = n / 2 - 1; i >= 0; i--)
            heapify(arr, n, i);

        for (int i = n - 1; i > 0; {
            int temp = arr[0];
            arr[0] = arr[i];
            arr[i] = temp;

            heapify(arr, i, 0);
        }
    }

    public static void printArray(int arr[]) {
        for (int i : arr) {
            System.out.print(i + " ");
        }
        System.out.println();
    }

    public static void main(String args[]) {
        int arr[] = {12, 11, 13, 5, 6, 7};
        HeapSort ob = new HeapSort();
        ob.heapSort(arr);
        printArray(arr);
    }
}
```
```python
def heapify(arr, n, i):
    largest = i
    left = 2 * i + 1
    right = 2 * i + 2

    if left < n and arr[left] > arr[largest]:
        largest = left

    if right < n and arr[right] > arr[largest]:
        largest = right

    if largest != i:
        arr[i], arr[largest] = arr[largest], arr[i]
        heapify(arr, n, largest)

def heap_sort(arr):
    n = len(arr)

    for i in range(n // 2 - 1, -1, -1):
        heapify(arr, n, i)

    for i in range(n - 1, 0, -1):
        arr[i], arr[0] = arr[0], arr[i]
        heapify(arr, i, 0)

def print_array(arr):
    for i in arr:
        print(i, end=" ")
    print()

arr = [12, 11, 13, 5, 6, 7]
heap_sort(arr)
print_array(arr)
```
```javascript
function heapify(arr, n, i) {
    let largest = i;
    let left = 2 * i + 1;
    let right = 2 * i + 2;

    if (left < n && arr[left] > arr[largest]) {
        largest = left;
    }

    if (right < n && arr[right] > arr[largest]) {
        largest = right;
    }

    if (largest != i) {
        [arr[i], arr[largest]] = [arr[largest], arr[i]];
        heapify(arr, n, largest);
    }
}

function heapSort(arr) {
    let n = arr.length;

    for (let i = Math.floor(n / 2) - 1; i >= 0; i--) {
        heapify(arr, n, i);
    }

    for (let i = n - 1; i > 0; i--) {
        [arr[0], arr[i]] = [arr[i], arr[0]];
        heapify(arr, i, 0);
    }
}

function printArray(arr) {
    console.log(arr.join(' '));
}

let arr = [12, 11, 13, 5, 6, 7];
heapSort(arr);
printArray(arr);
```

## Összegzés

A kupacrendezés egy hatékony és stabil rendezési algoritmus, amely különösen jól működik nagy méretű adatsorok rendezésére. Az algoritmus működése könnyen érthető és implementálható, és időbeli komplexitása O(n log n) a legrosszabb esetben is. Az in-place jellege miatt a kupacrendezés memóriahatékony, ami gyakran előnyös a gyakorlati alkalmazások során.

## További források

- [GeeksforGeeks - Heap Sort](https://www.geeksforgeeks.org/heap-sort/)
- [Wikipedia - Heapsort](https://en.wikipedia.org/wiki/Heapsort)
