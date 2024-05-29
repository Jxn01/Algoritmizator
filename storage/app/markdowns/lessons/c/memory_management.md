## Bevezetés

A memóriakezelés a programozás egyik legfontosabb területe, különösen a C és C++ nyelvekben. A dinamikus memóriakezelés lehetővé teszi a programok számára, hogy futásidőben foglaljanak és szabadítsanak fel memóriát. Ebben a leckében megvizsgáljuk a `malloc()`, `realloc()`, `calloc()` és `free()` függvények használatát, valamint a `sizeof()` függvényt és a nullpointer fogalmát. Különös figyelmet fordítunk a memóriakezelés elméletére és a heap működésére.

## Elméleti alapok

### A heap működése

A heap egy speciális memóriaterület, amelyet dinamikus memóriakezelésre használnak. A heap memóriát a program futása során osztja ki és szabadítja fel, ellentétben a stack-kel, amelyet a függvényhívások és lokális változók kezelnek. A heap memória kezelése manuálisan történik a `malloc()`, `realloc()`, `calloc()` és `free()` függvények segítségével.

### malloc()

A `malloc()` (memory allocation) függvény egy adott méretű memóriaterületet foglal le a heap-en, és visszaad egy pointert az első byte címére. A lefoglalt memória nem inicializált, azaz véletlenszerű értékeket tartalmazhat.

```cpp
int* ptr = (int*)malloc(sizeof(int) * 5);
if (ptr == nullptr) {
    std::cerr << "Memory allocation failed\n";
}
```

### calloc()

A `calloc()` (contiguous allocation) függvény szintén memóriát foglal, de a `malloc()`-kal ellentétben a memóriaterületet nullával inicializálja. Két paramétert vár: az elemek számát és az egyes elemek méretét.

```cpp
int* ptr = (int*)calloc(5, sizeof(int));
if (ptr == nullptr) {
    std::cerr << "Memory allocation failed\n";
}
```

### realloc()

A `realloc()` (reallocation) függvény egy már lefoglalt memóriaterület méretét módosítja. Ha a megadott méret kisebb, a felesleges memória felszabadul, ha nagyobb, akkor új memóriaterületet foglal és az eredeti tartalmat átmásolja az új helyre.

```cpp
int* ptr = (int*)realloc(ptr, sizeof(int) * 10);
if (ptr == nullptr) {
    std::cerr << "Memory reallocation failed\n";
}
```

### free()

A `free()` függvény felszabadítja a korábban lefoglalt memóriaterületet, hogy az újra felhasználható legyen. Fontos, hogy minden `malloc()`, `calloc()` vagy `realloc()` hívást követően használjuk a `free()`-t, hogy elkerüljük a memória szivárgást.

```cpp
free(ptr);
```

### sizeof()

A `sizeof()` operátor megadja egy adattípus vagy változó méretét byte-ban. Használata különösen fontos a dinamikus memóriakezelésnél, hogy biztosítsuk a megfelelő mennyiségű memória foglalását.

```cpp
int size = sizeof(int); // Eredmény: 4 byte (általában)
```

### Pointerek típuskonverziója

A pointerek típuskonverziója (casting) lehetővé teszi, hogy egy pointert más adattípusra konvertáljunk. Ez különösen hasznos dinamikus memóriakezelésnél, ahol a `malloc()` függvény által visszaadott `void*` pointert megfelelő típusra kell konvertálni.

```cpp
void* ptr = malloc(sizeof(int) * 5);
int* intPtr = (int*)ptr;
```

### Nullpointer

A nullpointer (nullptr) egy speciális pointer érték, amely nem mutat semmilyen memóriacímre. A nullpointer használata segít elkerülni a dereferencia hibákat, amikor egy pointer nem mutat érvényes memóriaterületre.

```cpp
int* ptr = nullptr;
if (ptr == nullptr) {
    std::cerr << "Pointer is null\n";
}
```

## Gyakorlati alkalmazások

### Dinamikus tömbök kezelése

A dinamikus tömbök segítségével futásidőben változtathatjuk a tömb méretét, ami különösen hasznos, ha előre nem ismert a szükséges memória mennyisége.

```cpp
#include <iostream>
#include <cstdlib>

int main() {
    int* arr = (int*)malloc(sizeof(int) * 5);
    if (arr == nullptr) {
        std::cerr << "Memory allocation failed\n";
        return 1;
    }

    for (int i = 0; i < 5; i++) {
        arr[i] = i + 1;
    }

    arr = (int*)realloc(arr, sizeof(int) * 10);
    if (arr == nullptr) {
        std::cerr << "Memory reallocation failed\n";
        return 1;
    }

    for (int i = 5; i < 10; i++) {
        arr[i] = i + 1;
    }

    for (int i = 0; i < 10; i++) {
        std::cout << arr[i] << " ";
    }

    free(arr);
    return 0;
}
```

### Dinamikus adatstruktúrák

A dinamikus memóriakezelés lehetővé teszi komplex adatstruktúrák, mint például láncolt listák, veremek vagy sorok létrehozását és kezelését.

```cpp
#include <iostream>
#include <cstdlib>

struct Node {
    int data;
    Node* next;
};

Node* createNode(int data) {
    Node* newNode = (Node*)malloc(sizeof(Node));
    if (newNode == nullptr) {
        std::cerr << "Memory allocation failed\n";
        exit(1);
    }
    newNode->data = data;
    newNode->next = nullptr;
    return newNode;
}

void freeList(Node* head) {
    Node* tmp;
    while (head != nullptr) {
        tmp = head;
        head = head->next;
        free(tmp);
    }
}

int main() {
    Node* head = createNode(1);
    head->next = createNode(2);
    head->next->next = createNode(3);

    Node* current = head;
    while (current != nullptr) {
        std::cout << current->data << " ";
        current = current->next;
    }

    freeList(head);
    return 0;
}
```

## Összegzés
A dinamikus memóriakezelés alapvető fontosságú a hatékony és rugalmas programok írásához. A `malloc()`, `realloc()`, `calloc()` és `free()` függvények használata lehetővé teszi, hogy a programozók pontosan irányítsák a memória felhasználását és optimalizálják a programok teljesítményét. Fontos azonban, hogy a memóriakezelés során figyelmesen járjunk el, hogy elkerüljük a memória szivárgásokat és a memóriával kapcsolatos hibákat.

## További források

- [GeeksforGeeks - Dynamic Memory Allocation in C](https://www.geeksforgeeks.org/dynamic-memory-allocation-in-c-using-malloc-calloc-free-and-realloc/)
- [Cplusplus.com - Dynamic Memory](http://www.cplusplus.com/doc/tutorial/dynamic/)
