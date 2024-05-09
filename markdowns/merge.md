# Merge Sort Megértése

Merge Sort, vagy magyarul "összefésülő rendezés", egy hatékony, összehasonlításon alapuló, stabil rendezési algoritmus. Ez az algoritmus a "megoszt és uralkodj" elvén működik. A következőkben bemutatjuk, hogyan működik ez az algoritmus lépésről lépésre.

## Algoritmus Leírása

1. **Felosztás:** Az algoritmus az adatsorozatot folyamatosan két részre osztja, amíg minden rész egyetlen elemet nem tartalmaz.
2. **Összefésülés:** Az egyelemű részeket az eredeti sorrendnek megfelelően összefésülik, miközben rendezik őket.

## Lépésről Lépésre

### 1. Lépés: Felosztás

Az adatsorozatot kettéosztjuk, amíg minden rész egyetlen elemet nem tartalmaz.

- Példa: `[3, 1, 4, 1, 5, 9, 2, 6, 5, 3, 5]`
    - Felosztás: `[3, 1, 4, 1, 5]` és `[9, 2, 6, 5, 3, 5]`

### 2. Lépés: Összefésülés és Rendezés

Az egyelemű részeket összefésüljük és rendezzük, hogy visszaállítsuk az adatsorozatot.

- Példa az összefésülésre:
    - `[3]` és `[1]` összefésülése: `[1, 3]`
    - Folytatás a többi elemmel...

## Összetettség

- **Időbeli összetettség:** Általános esetben \(O(n \log n)\), ami optimális összehasonlításon alapuló rendezésnél.
- **Térbeli összetettség:** Mivel a Merge Sort tömbök másolatát használja az összefésüléshez, ezért \(O(n)\) a térbeli összetettsége.

## Implementáció

```python
def merge_sort(arr):
    if len(arr) > 1:
        mid = len(arr) // 2
        L = arr[:mid]
        R = arr[mid:]

        merge_sort(L)
        merge_sort(R)

        i = j = k = 0

        while i < len(L) and j < len(R):
            if L[i] < R[j]:
                arr[k] = L[i]
                i += 1
            else:
                arr[k] = R[j]
                j += 1
            k += 1

        while i < len(L):
            arr[k] = L[i]
            i += 1
            k += 1

        while j < len(R):
            arr[k] = R[j]
            j += 1
            k += 1

return arr
```

```java
public class MergeSort {

    public static void sort(int[] array) {
        if (array.length < 2) {
            return;
        }
        int mid = array.length / 2;
        int[] left = new int[mid];
        int[] right = new int[array.length - mid];

        for (int i = 0; i < mid; i++) {
            left[i] = array[i];
        }
        for (int i = mid; i < array.length; i++) {
            right[i - mid] = array[i];
        }

        sort(left);
        sort(right);

        merge(array, left, right);
    }

    public static void merge(int[] array, int[] left, int[] right) {
        int i = 0, j = 0, k = 0;
        while (i < left.length && j < right.length) {
            if (left[i] <= right[j]) {
                array[k++] = left[i++];
            } else {
                array[k++] = right[j++];
            }
        }
        while (i < left.length) {
            array[k++] = left[i++];
        }
        while (j < right.length) {
            array[k++] = right[j++];
        }
    }

    public static void main(String[] args) {
        int[] array = {9, 3, 1, 5, 13, 22, 17, 11};
        sort(array);
        for (int i : array) {
            System.out.print(i + " ");
        }
    }
}
```

```cpp
#include <iostream>
#include <vector>

void merge(std::vector<int>& arr, int const left, int const mid, int const right) {
    auto const subArrayOne = mid - left + 1;
    auto const subArrayTwo = right - mid;

    std::vector<int> leftArray(subArrayOne), rightArray(subArrayTwo);

    for (auto i = 0; i < subArrayOne; i++)
        leftArray[i] = arr[left + i];
    for (auto j = 0; j < subArrayTwo; j++)
        rightArray[j] = arr[mid + 1 + j];

    auto indexOfSubArrayOne = 0, indexOfSubArrayTwo = 0;
    int indexOfMergedArray = left;

    while (indexOfSubArrayOne < subArrayOne && indexOfSubArrayTwo < subArrayTwo) {
        if (leftArray[indexOfSubArrayOne] <= rightArray[indexOfSubArrayTwo]) {
            arr[indexOfMergedArray] = leftArray[indexOfSubArrayOne];
            indexOfSubArrayOne++;
        } else {
            arr[indexOfMergedArray] = rightArray[indexOfSubArrayTwo];
            indexOfSubArrayTwo++;
        }
        indexOfMergedArray++;
    }
    while (indexOfSubArrayOne < subArrayOne) {
        arr[indexOfMergedArray] = leftArray[indexOfSubArrayOne];
        indexOfSubArrayOne++;
        indexOfMergedArray++;
    }
    while (indexOfSubArrayTwo < subArrayTwo) {
        arr[indexOfMergedArray] = rightArray[indexOfSubArrayTwo];
        indexOfSubArrayTwo++;
        indexOfMergedArray++;
    }
}

void mergeSort(std::vector<int>& arr, int const begin, int const end) {
    if (begin >= end)
        return;

    auto mid = begin + (end - begin) / 2;
    mergeSort(arr, begin, mid);
    mergeSort(arr, mid + 1, end);
    merge(arr, begin, mid, end);
}

void printArray(std::vector<int>& array) {
    for (int i : array) {
        std::cout << i << " ";
    }
    std::cout << '\n';
}

int main() {
    std::vector<int> arr = {12, 11, 13, 5, 6, 7};
    std::cout << "Given array is \n";
    printArray(arr);

    mergeSort(arr, 0, arr.size() - 1);

    std::cout << "Sorted array is \n";
    printArray(arr);
    return 0;
}
```

```javascript
function merge(left, right) {
    let array = [];
    while (left.length && right.length) {
        if (left[0] < right[0]) {
            array.push(left.shift());
        } else {
            array.push(right.shift());
        }
    }
    return [...array, ...left, ...right];
}

function mergeSort(array) {
    if (array.length < 2) {
        return array;
    }
    const middle = Math.floor(array.length / 2);
    const left = array.slice(0, middle);
    const right = array.slice(middle);
    return merge(mergeSort(left), mergeSort(right));
}

// Tesztelés
const arr = [34, 7, 23, 32, 5, 62];
console.log("Original array:", arr);
const sorted = mergeSort(arr);
console.log("Sorted array:", sorted);
```
