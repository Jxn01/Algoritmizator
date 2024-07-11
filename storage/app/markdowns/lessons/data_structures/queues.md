## Bevezetés

A sor (angolul queue) egy olyan adatszerkezet, amelyben az elemeket FIFO (First In, First Out) elv szerint kezeljük. Ez azt jelenti, hogy az elsőként beillesztett elem lesz az első, amit eltávolítunk. A sorok használata elengedhetetlen számos algoritmus és adatszerkezet megvalósításában. Ebben a leckében részletesen megvizsgáljuk a sor elméleti alapjait és gyakorlati alkalmazásait különböző programozási nyelveken.

## Elméleti alapok

### Sor definíciója

A sor egy olyan adatszerkezet, amely támogatja az elemek beszúrását (enqueue) a sor végére és eltávolítását (dequeue) a sor elejéről. A sor mindkét végén végrehajthatók műveletek, de eltávolítani csak az elejéről lehet, míg hozzáadni csak a végéhez.

### Sor memóriakezelése

A sor memóriakezelése lineáris adatszerkezetek esetén egyszerű, de körkörös sorok (circular queue) esetén hatékonyabb, mivel újrahasználhatóvá válik a felszabadított memória. Az elemek hozzáadása és eltávolítása O(1) időben történik, ami nagyon hatékony memória- és időfelhasználást biztosít.

### Absztrakt adattípus (ADT) sor

A sor absztrakt adattípus (ADT), amely a következő műveleteket támogatja:

- **Enqueue (Beszúrás)**: Új elem hozzáadása a sor végére.
- **Dequeue (Eltávolítás)**: A sor elején lévő elem eltávolítása.
- **Peek (Megtekintés)**: A sor elején lévő elem megtekintése eltávolítás nélkül.
- **IsEmpty (Üresség ellenőrzés)**: Annak ellenőrzése, hogy a sor üres-e.

### Sor alkalmazásai

- **Számítógépes hálózatok**: Az adatok átvitele során a csomagok sorban kerülnek feldolgozásra.
- **Operációs rendszerek**: A folyamatok ütemezése során a várakozási sorokat használják.
- **Szimuláció**: A valós világ eseményeinek modellezése során a sorokat használják a folyamatok ütemezésére.

## Sor gyakorlati alkalmazásai

### Sor létrehozása és kezelése

A következő kódpéldák bemutatják, hogyan lehet létrehozni és kezelni egy sort különböző programozási nyelveken.

```cpp
#include <iostream>
#include <queue>

int main() {
    std::queue<int> q;
    q.push(1);  // Enqueue
    q.push(2);
    q.push(3);

    while (!q.empty()) {
        std::cout << q.front() << " ";  // Peek
        q.pop();  // Dequeue
    }

    return 0;
}
```
```java
import java.util.LinkedList;
import java.util.Queue;

public class Main {
    public static void main(String[] args) {
        Queue<Integer> q = new LinkedList<>();
        q.add(1);  // Enqueue
        q.add(2);
        q.add(3);

        while (!q.isEmpty()) {
            System.out.print(q.peek() + " ");  // Peek
            q.remove();  // Dequeue
        }
    }
}
```
```python
from collections import deque

queue = deque()
queue.append(1)  # Enqueue
queue.append(2)
queue.append(3)

while queue:
    print(queue[0], end=" ")  # Peek
    queue.popleft()  # Dequeue
```
```javascript
let queue = [];
queue.push(1);  // Enqueue
queue.push(2);
queue.push(3);

while (queue.length > 0) {
    console.log(queue[0]);  // Peek
    queue.shift();  // Dequeue
}
```

### Sor műveletek részletesen

#### Enqueue művelet

Az enqueue művelet egy elem hozzáadása a sor végére. Az alábbi példákban bemutatjuk az enqueue művelet végrehajtását.

```cpp
#include <iostream>
#include <queue>

int main() {
    std::queue<int> q;
    q.push(10);
    std::cout << "Enqueued 10" << std::endl;
    return 0;
}
```
```java
import java.util.LinkedList;
import java.util.Queue;

public class Main {
    public static void main(String[] args) {
        Queue<Integer> q = new LinkedList<>();
        q.add(10);
        System.out.println("Enqueued 10");
    }
}
```
```python
from collections import deque

queue = deque()
queue.append(10)
print("Enqueued 10")
```
```javascript
let queue = [];
queue.push(10);
console.log("Enqueued 10");
```

#### Dequeue művelet

A dequeue művelet eltávolítja a sor elején lévő elemet. Az alábbi példákban bemutatjuk a dequeue művelet végrehajtását.

```cpp
#include <iostream>
#include <queue>

int main() {
    std::queue<int> q;
    q.push(10);
    q.push(20);
    q.pop();
    std::cout << "Dequeued front element" << std::endl;
    return 0;
}
```
```java
import java.util.LinkedList;
import java.util.Queue;

public class Main {
    public static void main(String[] args) {
        Queue<Integer> q = new LinkedList<>();
        q.add(10);
        q.add(20);
        q.remove();
        System.out.println("Dequeued front element");
    }
}
```
```python
from collections import deque

queue = deque()
queue.append(10)
queue.append(20)
queue.popleft()
print("Dequeued front element")
```
```javascript
let queue = [];
queue.push(10);
queue.push(20);
queue.shift();
console.log("Dequeued front element");
```

### Sor alkalmazások részletesen

#### Szimuláció sorokkal

A sorok szimulációja során modellezhetünk valós világ eseményeket, például egy ügyfélszolgálat várakozási sorát.

```cpp
#include <iostream>
#include <queue>

int main() {
    std::queue<std::string> customerQueue;
    customerQueue.push("Customer 1");
    customerQueue.push("Customer 2");
    customerQueue.push("Customer 3");

    while (!customerQueue.empty()) {
        std::cout << customerQueue.front() << " is being served." << std::endl;
        customerQueue.pop();
    }

    return 0;
}
```
```java
import java.util.LinkedList;
import java.util.Queue;

public class Main {
    public static void main(String[] args) {
        Queue<String> customerQueue = new LinkedList<>();
        customerQueue.add("Customer 1");
        customerQueue.add("Customer 2");
        customerQueue.add("Customer 3");

        while (!customerQueue.isEmpty()) {
            System.out.println(customerQueue.peek() + " is being served.");
            customerQueue.remove();
        }
    }
}
```
```python
from collections import deque

customer_queue = deque()
customer_queue.append("Customer 1")
customer_queue.append("Customer 2")
customer_queue.append("Customer 3")

while customer_queue:
    print(f"{customer_queue[0]} is being served.")
    customer_queue.popleft()
```
```javascript
let customerQueue = [];
customerQueue.push("Customer 1");
customerQueue.push("Customer 2");
customerQueue.push("Customer 3");

while (customerQueue.length > 0) {
    console.log(`${customerQueue[0]} is being served.`);
    customerQueue.shift();
}
```

## Összegzés

A sor alapvető adatszerkezet, amely számos fontos alkalmazással bír a számítástechnikában és a mindennapi életben. A fenti példák bemutatják, hogyan lehet sort létrehozni és használni különböző programozási nyelveken, valamint a sor gyakorlati alkalmazásait. A sor ismerete elengedhetetlen a programozási készségek fejlesztéséhez és a komplex algoritmusok megértéséhez.

## További források

- [GeeksforGeeks - Queue Data Structure](https://www.geeksforgeeks.org/queue-data-structure/)
- [Wikipedia - Queue (abstract data type)](https://en.wikipedia.org/wiki/Queue_(abstract_data_type))
