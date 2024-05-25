## Bevezetés

Az edényrendezés (angolul Bucket Sort) egy olyan rendezési algoritmus, amely az elemeket különböző csoportokba (edényekbe) osztja, majd minden edényt külön rendez, és végül összeilleszti a rendezett edényeket. Az algoritmus különösen hatékony lehet, ha az elemek egyenletesen oszlanak el egy ismert tartományban.

## Elméleti alapok

### Edényrendezés működése

Az edényrendezés az alábbi lépésekből áll:
1. **Edények létrehozása**: Osszuk az elemeket több edénybe.
2. **Elemek elhelyezése**: Helyezzük el az elemeket az edényekbe a megfelelő kritériumok alapján.
3. **Edények rendezése**: Minden edényt külön-külön rendezzünk.
4. **Összeillesztés**: Illesszük össze a rendezett edényeket, hogy megkapjuk a rendezett adatsort.

### Algoritmus lépései

1. Hozzunk létre egy üres listát minden edényhez.
2. Iteráljunk végig az adatsoron, és minden elemet helyezzünk el a megfelelő edénybe.
3. Rendezzük minden edényt külön-külön (általában egy egyszerűbb rendezési algoritmussal, mint a beszúró rendezés).
4. Illesszük össze a rendezett edényeket egy rendezett adatsorrá.

### Idő- és térbeli komplexitás

- **Időbeli komplexitás**: Átlagosan O(n + k), ahol n az elemek száma és k az edények száma.
- **Térbeli komplexitás**: O(n + k), mivel extra memóriát igényel az edények és az átmeneti tárolás számára.

## Gyakorlati alkalmazások

### Számok rendezése ismert tartományban

Az edényrendezés különösen hatékony, ha az elemek egyenletesen oszlanak el egy ismert tartományban, például lebegőpontos számok 0 és 1 között.

### Nagy adatsorok rendezése

Az edényrendezés jól skálázható nagy adatsorok esetén, mivel az elemeket párhuzamosan lehet elhelyezni és rendezni az edényekben.

### Edényrendezés implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják az edényrendezés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>
#include <algorithm>

void bucketSort(std::vector<float>& arr) {
    int n = arr.size();
    std::vector<float> b[n];

    for (int i = 0; i < n; i++) {
        int bi = n * arr[i];
        b[bi].push_back(arr[i]);
    }

    for (int i = 0; i < n; i++) {
        std::sort(b[i].begin(), b[i].end());
    }

    int index = 0;
    for (int i = 0; i < n; i++) {
        for (size_t j = 0; j < b[i].size(); j++) {
            arr[index++] = b[i][j];
        }
    }
}

void printArray(const std::vector<float>& arr) {
    for (float i : arr) {
        std::cout << i << " ";
    }
    std::cout << std::endl;
}

int main() {
    std::vector<float> arr = {0.897, 0.565, 0.656, 0.1234, 0.665, 0.3434};
    bucketSort(arr);
    printArray(arr);
    return 0;
}
```
```java
import java.util.*;

public class BucketSort {
    public static void bucketSort(float arr[], int n) {
        if (n <= 0)
            return;

        @SuppressWarnings("unchecked")
        ArrayList<Float>[] bucket = new ArrayList[n];

        for (int i = 0; i < n; i++) {
            bucket[i] = new ArrayList<Float>();
        }

        for (int i = 0; i < n; i++) {
            int bucketIndex = (int) arr[i] * n;
            bucket[bucketIndex].add(arr[i]);
        }

        for (int i = 0; i < n; i++) {
            Collections.sort(bucket[i]);
        }

        int index = 0;
        for (int i = 0; i < n; i++) {
            for (int j = 0; j < bucket[i].size(); j++) {
                arr[index++] = bucket[i].get(j);
            }
        }
    }

    public static void printArray(float arr[], int n) {
        for (float i : arr) {
            System.out.print(i + " ");
        }
        System.out.println();
    }

    public static void main(String[] args) {
        float arr[] = { (float) 0.897, (float) 0.565, (float) 0.656, (float) 0.1234, (float) 0.665, (float) 0.3434 };
        int n = arr.length;
        bucketSort(arr, n);
        printArray(arr, n);
    }
}
```
```python
def bucket_sort(arr):
    n = len(arr)
    buckets = [[] for _ in range(n)]

    for i in arr:
        index = int(n * i)
        buckets[index].append(i)

    for i in range(n):
        buckets[i].sort()

    result = []
    for bucket in buckets:
        result.extend(bucket)

    for i in range(len(arr)):
        arr[i] = result[i]

def print_array(arr):
    for i in arr:
        print(i, end=" ")
    print()

arr = [0.897, 0.565, 0.656, 0.1234, 0.665, 0.3434]
bucket_sort(arr)
print_array(arr)
```
```javascript
function bucketSort(arr) {
    let n = arr.length;
    let buckets = Array.from({ length: n }, () => []);

    for (let i = 0; i < n; i++) {
        let index = Math.floor(n * arr[i]);
        buckets[index].push(arr[i]);
    }

    for (let i = 0; i < n; i++) {
        buckets[i].sort((a, b) => a - b);
    }

    let index = 0;
    for (let i = 0; i < n; i++) {
        for (let j = 0; j < buckets[i].length; j++) {
            arr[index++] = buckets[i][j];
        }
    }
}

function printArray(arr) {
    console.log(arr.join(' '));
}

let arr = [0.897, 0.565, 0.656, 0.1234, 0.665, 0.3434];
bucketSort(arr);
printArray(arr);
```

## Összegzés

Az edényrendezés egy hatékony rendezési algoritmus, amely különösen jól működik, ha az elemek egyenletesen oszlanak el egy ismert tartományban. Az algoritmus időbeli komplexitása átlagosan O(n + k), és jól skálázható nagy adatsorok esetén. Az edényrendezés használata széles körben elterjedt olyan alkalmazásokban, ahol a rendezendő elemek tartománya előre ismert.

## További források

- [GeeksforGeeks - Bucket Sort](https://www.geeksforgeeks.org/bucket-sort/)
- [Wikipedia - Bucket Sort](https://en.wikipedia.org/wiki/Bucket_sort)
