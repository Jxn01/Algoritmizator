## Bevezetés

A hash tábla egy olyan adatszerkezet, amely kulcs-érték párokat tárol, és egy hash függvényt használ a kulcsok indexelésére. A hash tábla rendkívül hatékony adatkeresést és -tárolást tesz lehetővé, és széles körben használatos különböző alkalmazásokban, például adatbázisokban, cache-ekben és szótárakban.

## Elméleti alapok

### Hash tábla definíciója

A hash tábla egy olyan adatszerkezet, amely kulcs-érték párokat tárol. A hash függvény egy adott kulcsot egy egész számra képez le, amelyet indexként használnak az értékek tárolására egy tömbben. A hash tábla lehetővé teszi az O(1) idejű adatkeresést és -beszúrást, feltéve, hogy a hash függvény jól van megválasztva és minimális ütközést okoz.

### Hash függvény

A hash függvény egy matematikai függvény, amely egy bemeneti adatot (kulcsot) egy egész számra képez le. A jó hash függvény jellemzői:

- **Determinisztikus**: Ugyanazt a kulcsot mindig ugyanarra az egész számra képezi le.
- **Gyors**: Hatékonyan számítható.
- **Egyenletes eloszlás**: Egyenletesen osztja el a kulcsokat a hash tábla indexei között, minimalizálva az ütközéseket.

### Ütközéskezelés

Az ütközés akkor következik be, amikor két különböző kulcsot ugyanaz a hash érték indexel. Az ütközés kezelésére több módszer létezik:

- **Láncolás (Chaining)**: Minden hash értékhez egy láncolt lista (vagy más adatszerkezet) tartozik, amely az adott indexhez tartozó összes elemet tárolja.
- **Nyílt címzés (Open Addressing)**: Az ütközött elemeket a hash táblán belül új helyre helyezzük el egy meghatározott szabály szerint (pl. lineáris próba, kvadratikus próba).

### Absztrakt adattípus (ADT) hash tábla

A hash tábla absztrakt adattípus (ADT), amely a következő műveleteket támogatja:

- **Insert (Beszúrás)**: Új kulcs-érték pár hozzáadása a hash táblához.
- **Delete (Eltávolítás)**: Egy kulcs-érték pár eltávolítása a hash táblából.
- **Search (Keresés)**: Egy érték keresése a hash táblában egy adott kulcs alapján.

## Hash tábla gyakorlati alkalmazásai

### Egyszerű hash tábla létrehozása és kezelése

A következő kódpéldák bemutatják, hogyan lehet létrehozni és kezelni egy egyszerű hash táblát különböző programozási nyelveken.

```cpp
#include <iostream>
#include <list>
#include <vector>

class HashTable {
private:
    std::vector<std::list<std::pair<int, std::string>>> table;
    int size;

    int hashFunction(int key) {
        return key % size;
    }

public:
    HashTable(int size) : size(size) {
        table.resize(size);
    }

    void insert(int key, const std::string& value) {
        int hash = hashFunction(key);
        for (auto& kv : table[hash]) {
            if (kv.first == key) {
                kv.second = value;
                return;
            }
        }
        table[hash].emplace_back(key, value);
    }

    void remove(int key) {
        int hash = hashFunction(key);
        table[hash].remove_if([key](const auto& kv) { return kv.first == key; });
    }

    std::string search(int key) {
        int hash = hashFunction(key);
        for (const auto& kv : table[hash]) {
            if (kv.first == key) {
                return kv.second;
            }
        }
        return "";
    }
};

int main() {
    HashTable ht(10);
    ht.insert(1, "One");
    ht.insert(2, "Two");
    ht.insert(3, "Three");

    std::cout << "Key 2: " << ht.search(2) << std::endl;

    ht.remove(2);
    std::cout << "Key 2: " << ht.search(2) << std::endl;

    return 0;
}
```
```java
import java.util.LinkedList;

class HashTable {
    private class Pair {
        int key;
        String value;

        Pair(int key, String value) {
            this.key = key;
            this.value = value;
        }
    }

    private LinkedList<Pair>[] table;
    private int size;

    public HashTable(int size) {
        this.size = size;
        table = new LinkedList[size];
        for (int i = 0; i < size; i++) {
            table[i] = new LinkedList<>();
        }
    }

    private int hashFunction(int key) {
        return key % size;
    }

    public void insert(int key, String value) {
        int hash = hashFunction(key);
        for (Pair pair : table[hash]) {
            if (pair.key == key) {
                pair.value = value;
                return;
            }
        }
        table[hash].add(new Pair(key, value));
    }

    public void remove(int key) {
        int hash = hashFunction(key);
        table[hash].removeIf(pair -> pair.key == key);
    }

    public String search(int key) {
        int hash = hashFunction(key);
        for (Pair pair : table[hash]) {
            if (pair.key == key) {
                return pair.value;
            }
        }
        return null;
    }

    public static void main(String[] args) {
        HashTable ht = new HashTable(10);
        ht.insert(1, "One");
        ht.insert(2, "Two");
        ht.insert(3, "Three");

        System.out.println("Key 2: " + ht.search(2));

        ht.remove(2);
        System.out.println("Key 2: " + ht.search(2));
    }
}
```
```python
class HashTable:
    def __init__(self, size):
        self.size = size
        self.table = [[] for _ in range(size)]

    def hash_function(self, key):
        return key % self.size

    def insert(self, key, value):
        hash_key = self.hash_function(key)
        for kv in self.table[hash_key]:
            if kv[0] == key:
                kv[1] = value
                return
        self.table[hash_key].append([key, value])

    def remove(self, key):
        hash_key = self.hash_function(key)
        self.table[hash_key] = [kv for kv in self.table[hash_key] if kv[0] != key]

    def search(self, key):
        hash_key = self.hash_function(key)
        for kv in self.table[hash_key]:
            if kv[0] == key:
                return kv[1]
        return None

ht = HashTable(10)
ht.insert(1, "One")
ht.insert(2, "Two")
ht.insert(3, "Three")

print("Key 2:", ht.search(2))

ht.remove(2)
print("Key 2:", ht.search(2))
```
```javascript
class HashTable {
    constructor(size) {
        this.size = size;
        this.table = new Array(size).fill(null).map(() => []);
    }

    hashFunction(key) {
        return key % this.size;
    }

    insert(key, value) {
        const hash = this.hashFunction(key);
        for (const kv of this.table[hash]) {
            if (kv[0] === key) {
                kv[1] = value;
                return;
            }
        }
        this.table[hash].push([key, value]);
    }

    remove(key) {
        const hash = this.hashFunction(key);
        this.table[hash] = this.table[hash].filter(kv => kv[0] !== key);
    }

    search(key) {
        const hash = this.hashFunction(key);
        for (const kv of this.table[hash]) {
            if (kv[0] === key) {
                return kv[1];
            }
        }
        return null;
    }
}

const ht = new HashTable(10);
ht.insert(1, "One");
ht.insert(2, "Two");
ht.insert(3, "Three");

console.log("Key 2:", ht.search(2));

ht.remove(2);
console.log("Key 2:", ht.search(2));
```

### Hash tábla alkalmazások részletesen

#### Elem beszúrása (Insert)

Az insert művelet egy új kulcs-érték pár hozzáadását jelenti a hash táblához. Az alábbi példák bemutatják az insert művelet végrehajtását különböző programozási nyelveken.

```cpp
#include <iostream>
#include <list>
#include <vector>

class HashTable {
private:
    std::vector<std::list<std::pair<int, std::string>>> table;
    int size;

    int hashFunction(int key) {
        return key % size;
    }

public:
    HashTable(int size) : size(size) {
        table.resize(size);
    }

    void insert(int key, const std::string& value) {
        int hash = hashFunction(key);
        for (auto& kv : table[hash]) {
            if (kv.first == key) {
                kv.second = value;
                return;
            }
        }
        table[hash].emplace_back(key, value);
    }

    void printTable() {
        for (int i = 0; i < size; ++i) {
            std::cout << i << ": ";
            for (const auto& kv : table[i]) {
                std::cout << "{" << kv.first << ", " << kv.second << "} ";
            }
            std::cout << std::endl;
        }
    }
};

int main() {
    HashTable ht(10);
    ht.insert(1, "One");
    ht.insert(2, "Two");
    ht.insert(3, "Three");

    ht.printTable();
    return 0;
}
```
```java
import java.util.LinkedList;

class HashTable {
    private class Pair {
        int key;
        String value;

        Pair(int key, String value) {
            this.key = key;
            this.value = value;
        }
    }

    private LinkedList<Pair>[] table;
    private int size;

    public HashTable(int size) {
        this.size = size;
        table = new LinkedList[size];
        for (int i = 0; i < size; i++) {
            table[i] = new LinkedList<>();
        }
    }

    private int hashFunction(int key) {
        return key % size;
    }

    public void insert(int key, String value) {
        int hash = hashFunction(key);
        for (Pair pair : table[hash]) {
            if (pair.key == key) {
                pair.value = value;
                return;
            }
        }
        table[hash].add(new Pair(key, value));
    }

    public void printTable() {
        for (int i = 0; i < size; i++) {
            System.out.print(i + ": ");
            for (Pair pair : table[i]) {
                System.out.print("{" + pair.key + ", " + pair.value + "} ");
            }
            System.out.println();
        }
    }

    public static void main(String[] args) {
        HashTable ht = new HashTable(10);
        ht.insert(1, "One");
        ht.insert(2, "Two");
        ht.insert(3, "Three");

        ht.printTable();
    }
}
```
```python
class HashTable:
    def __init__(self, size):
        self.size = size
        self.table = [[] for _ in range(size)]

    def hash_function(self, key):
        return key % self.size

    def insert(self, key, value):
        hash_key = self.hash_function(key)
        for kv in self.table[hash_key]:
            if kv[0] == key:
                kv[1] = value
                return
        self.table[hash_key].append([key, value])

    def print_table(self):
        for i, lst in enumerate(self.table):
            print(f"{i}: ", end="")
            for kv in lst:
                print(f"{{ {kv[0]}, {kv[1]} }} ", end="")
            print()

ht = HashTable(10)
ht.insert(1, "One")
ht.insert(2, "Two")
ht.insert(3, "Three")

ht.print_table()
```
```javascript
class HashTable {
    constructor(size) {
        this.size = size;
        this.table = new Array(size).fill(null).map(() => []);
    }

    hashFunction(key) {
        return key % this.size;
    }

    insert(key, value) {
        const hash = this.hashFunction(key);
        for (const kv of this.table[hash]) {
            if (kv[0] === key) {
                kv[1] = value;
                return;
            }
        }
        this.table[hash].push([key, value]);
    }

    printTable() {
        this.table.forEach((list, index) => {
            console.log(`${index}:`, list.map(kv => `{${kv[0]}, ${kv[1]}}`).join(" "));
        });
    }
}

const ht = new HashTable(10);
ht.insert(1, "One");
ht.insert(2, "Two");
ht.insert(3, "Three");

ht.printTable();
```

## Összegzés

A hash tábla egy hatékony adatszerkezet, amely kulcs-érték párokat tárol, és gyors keresési, beszúrási és törlési műveleteket tesz lehetővé. A hash függvény és az ütközéskezelési stratégia megfelelő kiválasztása kulcsfontosságú a hash tábla teljesítményének optimalizálása szempontjából. A fenti példák bemutatják, hogyan lehet hash táblát létrehozni és használni különböző programozási nyelveken.

## További források

- [GeeksforGeeks - Hash Table Data Structure](https://www.geeksforgeeks.org/hashing-data-structure/)
- [Wikipedia - Hash Table](https://en.wikipedia.org/wiki/Hash_table)
