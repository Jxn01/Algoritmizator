## Bevezetés

A leszámláló rendezés (angolul Counting Sort) egy nem-komparatív rendezési algoritmus, amely az elemek előfordulási gyakoriságát használja a rendezéshez. Az algoritmus különösen hatékony lehet, ha az elemek egy szűk tartományban helyezkednek el, és nem tartalmaznak túl nagy értékeket.

## Elméleti alapok

### Leszámláló rendezés működése

A leszámláló rendezés az alábbi lépésekből áll:
1. **Előfordulások számlálása**: Hozzunk létre egy számláló tömböt, amely tárolja az egyes elemek előfordulási gyakoriságát.
2. **Prefix összegek képzése**: Alakítsuk át a számláló tömböt prefix összegek tömbjévé, amely megadja az elemek pozícióját a rendezett tömbben.
3. **Elemek elhelyezése**: Helyezzük el az elemeket a megfelelő pozícióba a rendezett tömbben.

### Algoritmus lépései

1. Hozzunk létre egy számláló tömböt, amelynek mérete a rendezendő elemek maximális értékétől függ.
2. Számoljuk meg az egyes elemek előfordulási gyakoriságát és tároljuk a számláló tömbben.
3. Alakítsuk át a számláló tömböt prefix összegek tömbjévé.
4. Helyezzük el az elemeket a megfelelő pozícióba a rendezett tömbben.

### Idő- és térbeli komplexitás

- **Időbeli komplexitás**: O(n + k), ahol n az elemek száma és k a legnagyobb érték az adatsorban.
- **Térbeli komplexitás**: O(n + k), mivel extra memóriát igényel a számláló és a kimeneti tömbök számára.

## Gyakorlati alkalmazások

### Kis tartományú adatok rendezése

A leszámláló rendezés különösen hatékony, ha az elemek egy kis tartományban helyezkednek el, például szavazatok, korosztályok vagy más kategóriák esetén.

### Radix rendezés részeként

A leszámláló rendezés gyakran használatos a radix rendezés részeként, ahol az egyes helyiértékeket külön rendezik.

### Leszámláló rendezés implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják a leszámláló rendezés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>
#include <algorithm>

void countingSort(std::vector<int>& arr) {
    int max = *std::max_element(arr.begin(), arr.end());
    int min = *std::min_element(arr.begin(), arr.end());
    int range = max - min + 1;

    std::vector<int> count(range), output(arr.size());
    for (int i = 0; i < arr.size(); i++) {
        count[arr[i] - min]++;
    }

    for (int i = 1; i < count.size(); i++) {
        count[i] += count[i - 1];
    }

    for (int i = arr.size() - 1; i >= 0; i--) {
        output[count[arr[i] - min] - 1] = arr[i];
        count[arr[i] - min]--;
    }

    for (int i = 0; i < arr.size(); i++) {
        arr[i] = output[i];
    }
}

void printArray(const std::vector<int>& arr) {
    for (int i : arr) {
        std::cout << i << " ";
    }
    std::cout << std::endl;
}

int main() {
    std::vector<int> arr = {4, 2, 2, 8, 3, 3, 1};
    countingSort(arr);
    printArray(arr);
    return 0;
}
```
```java
import java.util.Arrays;

public class CountingSort {
    public static void countingSort(int arr[]) {
        int max = Arrays.stream(arr).max().getAsInt();
        int min = Arrays.stream(arr).min().getAsInt();
        int range = max - min + 1;

        int count[] = new int[range];
        int output[] = new int[arr.length];

        for (int i = 0; i < arr.length; i++) {
            count[arr[i] - min]++;
        }

        for (int i = 1; i < count.length; i++) {
            count[i] += count[i - 1];
        }

        for (int i = arr.length - 1; i >= 0; i--) {
            output[count[arr[i] - min] - 1] = arr[i];
            count[arr[i] - min]--;
        }

        for (int i = 0; i < arr.length; i++) {
            arr[i] = output[i];
        }
    }

    public static void printArray(int arr[]) {
        for (int i : arr) {
            System.out.print(i + " ");
        }
        System.out.println();
    }

    public static void main(String[] args) {
        int arr[] = {4, 2, 2, 8, 3, 3, 1};
        countingSort(arr);
        printArray(arr);
    }
}
```
```python
def counting_sort(arr):
    max_val = max(arr)
    min_val = min(arr)
    range_val = max_val - min_val + 1

    count = [0] * range_val
    output = [0] * len(arr)

    for i in arr:
        count[i - min_val] += 1

    for i in range(1, len(count)):
        count[i] += count[i - 1]

    for i in range(len(arr) - 1, -1, -1):
        output[count[arr[i] - min_val] - 1] = arr[i]
        count[arr[i] - min_val] -= 1

    for i in range(len(arr)):
        arr[i] = output[i]

def print_array(arr):
    for i in arr:
        print(i, end=" ")
    print()

arr = [4, 2, 2, 8, 3, 3, 1]
counting_sort(arr)
print_array(arr)
```
```javascript
function countingSort(arr) {
    let max = Math.max(...arr);
    let min = Math.min(...arr);
    let range = max - min + 1;

    let count = new Array(range).fill(0);
    let output = new Array(arr.length).fill(0);

    for (let i = 0; i < arr.length; i++) {
        count[arr[i] - min]++;
    }

    for (let i = 1; i < count.length; i++) {
        count[i] += count[i - 1];
    }

    for (let i = arr.length - 1; i >= 0; i--) {
        output[count[arr[i] - min] - 1] = arr[i];
        count[arr[i] - min]--;
    }

    for (let i = 0; i < arr.length; i++) {
        arr[i] = output[i];
    }
}

function printArray(arr) {
    console.log(arr.join(' '));
}

let arr = [4, 2, 2, 8, 3, 3, 1];
countingSort(arr);
printArray(arr);
```

## Összegzés

A leszámláló rendezés egy hatékony nem-komparatív rendezési algoritmus, amely különösen jól működik kis tartományú adatok esetén. Az algoritmus időbeli komplexitása O(n + k), és gyakran használják olyan alkalmazásokban, ahol a rendezendő elemek tartománya előre ismert. A leszámláló rendezés gyakran használatos a radix rendezés részeként is, ahol az egyes helyiértékeket külön rendezik.

## További források

- [GeeksforGeeks - Counting Sort](https://www.geeksforgeeks.org/counting-sort/)
- [Wikipedia - Counting Sort](https://en.wikipedia.org/wiki/Counting_sort)
