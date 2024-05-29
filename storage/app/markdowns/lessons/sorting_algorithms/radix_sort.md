## Bevezetés

A radix rendezés egy nem-komparatív rendezési algoritmus, amely számjegyek vagy karakterek alapján rendezi az elemeket. Az algoritmus különösen hatékony lehet nagy adatsorok esetén, ha az elemek fix hosszúságúak. A radix rendezés az adatok számjegyeit vagy karaktereit külön-külön rendezi, kezdve a legkevésbé jelentős helyiértékkel (LSD - Least Significant Digit) vagy a legjelentősebb helyiértékkel (MSD - Most Significant Digit).

## Elméleti alapok

### Radix rendezés működése

A radix rendezés lényege, hogy az elemeket több körben rendezi, mindegyik körben egy adott helyiérték alapján. A rendezést általában stabil rendezési algoritmussal (például counting sort) végzik, hogy megőrizzék az azonos helyiértékű elemek eredeti sorrendjét.

### Algoritmus lépései (LSD Radix Sort)

1. Kezdjük a legkisebb helyiértékkel (pl. egyes helyiérték).
2. Stabil rendezési algoritmussal rendezzük az elemeket ezen a helyiértéken.
3. Ismételjük a folyamatot a következő helyiértékkel, amíg az összes helyiértéket nem rendeztük.

### Idő- és térbeli komplexitás

- **Időbeli komplexitás**: O(d*(n+k)), ahol n az elemek száma, k a helyiértékek száma, d pedig az adott helyiérték maximális értéke.
- **Térbeli komplexitás**: O(n + k), mivel kiegészítő memóriát igényel a stabil rendezés végrehajtásához.

## Gyakorlati alkalmazások

### Fix hosszúságú adatok rendezése

A radix rendezés különösen hatékony fix hosszúságú adatok rendezésére, mint például szavak, azonosítók vagy telefonszámok.

### Nagy adatsorok rendezése

A radix rendezés jól skálázható nagy adatsorok esetén, mivel a nem-komparatív természetének köszönhetően gyorsabb lehet, mint a komparatív rendezési algoritmusok.

### Radix rendezés implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják a radix rendezés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>
#include <algorithm>

int getMax(const std::vector<int>& arr) {
    return *std::max_element(arr.begin(), arr.end());
}

void countSort(std::vector<int>& arr, int exp) {
    int n = arr.size();
    std::vector<int> output(n);
    int count[10] = {0};

    for (int i = 0; i < n; i++)
        count[(arr[i] / exp) % 10]++;

    for (int i = 1; i < 10; i++)
        count[i] += count[i - 1];

    for (int i = n - 1; i >= 0; i--) {
        output[count[(arr[i] / exp) % 10] - 1] = arr[i];
        count[(arr[i] / exp) % 10]--;
    }

    for (int i = 0; i < n; i++)
        arr[i] = output[i];
}

void radixSort(std::vector<int>& arr) {
    int max = getMax(arr);

    for (int exp = 1; max / exp > 0; exp *= 10)
        countSort(arr, exp);
}

void printArray(const std::vector<int>& arr) {
    for (int i : arr)
        std::cout << i << " ";
    std::cout << std::endl;
}

int main() {
    std::vector<int> arr = {170, 45, 75, 90, 802, 24, 2, 66};
    radixSort(arr);
    printArray(arr);
    return 0;
}
```
```java
import java.util.Arrays;

public class RadixSort {
    static int getMax(int arr[], int n) {
        int max = arr[0];
        for (int i = 1; i < n; i++)
            if (arr[i] > max)
                max = arr[i];
        return max;
    }

    static void countSort(int arr[], int n, int exp) {
        int output[] = new int[n];
        int count[] = new int[10];
        Arrays.fill(count, 0);

        for (int i = 0; i < n; i++)
            count[(arr[i] / exp) % 10]++;

        for (int i = 1; i < 10; i++)
            count[i] += count[i - 1];

        for (int i = n - 1; i >= 0; i--) {
            output[count[(arr[i] / exp) % 10] - 1] = arr[i];
            count[(arr[i] / exp) % 10]--;
        }

        for (int i = 0; i < n; i++)
            arr[i] = output[i];
    }

    static void radixSort(int arr[], int n) {
        int max = getMax(arr, n);

        for (int exp = 1; max / exp > 0; exp *= 10)
            countSort(arr, n, exp);
    }

    static void printArray(int arr[], int n) {
        for (int i = 0; i < n; i++)
            System.out.print(arr[i] + " ");
        System.out.println();
    }

    public static void main(String[] args) {
        int arr[] = {170, 45, 75, 90, 802, 24, 2, 66};
        int n = arr.length;
        radixSort(arr, n);
        printArray(arr, n);
    }
}
```
```python
def get_max(arr):
    return max(arr)

def count_sort(arr, exp):
    n = len(arr)
    output = [0] * n
    count = [0] * 10

    for i in range(n):
        index = (arr[i] // exp) % 10
        count[index] += 1

    for i in range(1, 10):
        count[i] += count[i - 1]

    i = n - 1
    while i >= 0:
        index = (arr[i] // exp) % 10
        output[count[index] - 1] = arr[i]
        count[index] -= 1
        i -= 1

    for i in range(n):
        arr[i] = output[i]

def radix_sort(arr):
    max_num = get_max(arr)
    exp = 1
    while max_num // exp > 0:
        count_sort(arr, exp)
        exp *= 10

def print_array(arr):
    for i in arr:
        print(i, end=" ")
    print()

arr = [170, 45, 75, 90, 802, 24, 2, 66]
radix_sort(arr)
print_array(arr)
```
```javascript
function getMax(arr) {
    return Math.max(...arr);
}

function countSort(arr, exp) {
    let n = arr.length;
    let output = new Array(n).fill(0);
    let count = new Array(10).fill(0);

    for (let i = 0; i < n; i++) {
        let index = Math.floor(arr[i] / exp) % 10;
        count[index]++;
    }

    for (let i = 1; i < 10; i++) {
        count[i] += count[i - 1];
    }

    for (let i = n - 1; i >= 0; i--) {
        let index = Math.floor(arr[i] / exp) % 10;
        output[count[index] - 1] = arr[i];
        count[index]--;
    }

    for (let i = 0; i < n; i++) {
        arr[i] = output[i];
    }
}

function radixSort(arr) {
    let max = getMax(arr);
    for (let exp = 1; Math.floor(max / exp) > 0; exp *= 10) {
        countSort(arr, exp);
    }
}

function printArray(arr) {
    console.log(arr.join(' '));
}

let arr = [170, 45, 75, 90, 802, 24, 2, 66];
radixSort(arr);
printArray(arr);
```

## Összegzés

A radix rendezés egy hatékony nem-komparatív rendezési algoritmus, amely különösen jól működik fix hosszúságú adatok esetén. Az algoritmus időbeli komplexitása O(d*(n+k)), ami gyorsabb lehet, mint a komparatív rendezési algoritmusok, különösen nagy adatsorok esetén. Az algoritmus használata széles körben elterjedt olyan alkalmazásokban, ahol a rendezendő elemek fix méretűek vagy számjegyekből állnak.

Források:
- [GeeksforGeeks - Radix Sort](https://www.geeksforgeeks.org/radix-sort/)
- [Wikipedia - Radix Sort](https://en.wikipedia.org/wiki/Radix_sort)
