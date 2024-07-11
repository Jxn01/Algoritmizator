## Bevezetés

A lista (angolul list) egy olyan adatszerkezet, amely az elemek sorozatát tárolja, ahol az elemek különböző típusúak lehetnek és dinamikusan változtathatók. A listák használata elengedhetetlen számos algoritmus és adatszerkezet megvalósításában. Ebben a leckében részletesen megvizsgáljuk a lista elméleti alapjait és gyakorlati alkalmazásait különböző programozási nyelveken.

## Elméleti alapok

### Lista definíciója

A lista egy dinamikus adatszerkezet, amely támogatja az elemek tetszőleges pozícióban történő beszúrását, eltávolítását és elérését. A lista elemei általában láncolt elemekből (csomópontokból) állnak, ahol minden csomópont egy elemet és egy hivatkozást tartalmaz a következő csomópontra.

### Lista típusai

- **Egyszeresen láncolt lista**: Minden csomópont tartalmaz egy elemet és egy hivatkozást a következő csomópontra.
- **Kétszeresen láncolt lista**: Minden csomópont tartalmaz egy elemet, egy hivatkozást a következő csomópontra és egy hivatkozást az előző csomópontra.
- **Cirkuláris láncolt lista**: A lista utolsó csomópontja az első csomópontra mutat, így a lista körkörös.

### Lista memóriakezelése

A lista dinamikusan kezeli a memóriát, ami azt jelenti, hogy az elemek hozzáadása és eltávolítása során a memória igény szerint foglalható és szabadítható fel. Ez lehetővé teszi a lista méretének rugalmas kezelését, de egyben bonyolultabb memóriakezelést is igényel.

### Absztrakt adattípus (ADT) lista

A lista absztrakt adattípus (ADT), amely a következő műveleteket támogatja:

- **Insert (Beszúrás)**: Új elem beszúrása a lista tetszőleges pozíciójába.
- **Delete (Eltávolítás)**: Egy elem eltávolítása a lista tetszőleges pozíciójából.
- **Search (Keresés)**: Egy elem keresése a listában.
- **Access (Hozzáférés)**: Egy elem elérése a lista tetszőleges pozíciójából.

## Lista gyakorlati alkalmazásai

### Egyszerű lista létrehozása és kezelése

A következő kódpéldák bemutatják, hogyan lehet létrehozni és kezelni egy egyszerű láncolt listát különböző programozási nyelveken.

```cpp
#include <iostream>

struct Node {
    int data;
    Node* next;
    Node(int data) : data(data), next(nullptr) {}
};

class LinkedList {
public:
    LinkedList() : head(nullptr) {}

    void insert(int data) {
        Node* newNode = new Node(data);
        newNode->next = head;
        head = newNode;
    }

    void print() {
        Node* temp = head;
        while (temp != nullptr) {
            std::cout << temp->data << " ";
            temp = temp->next;
        }
        std::cout << std::endl;
    }

private:
    Node* head;
};

int main() {
    LinkedList list;
    list.insert(1);
    list.insert(2);
    list.insert(3);
    list.print();

    return 0;
}
```
```java
class Node {
    int data;
    Node next;

    Node(int data) {
        this.data = data;
        this.next = null;
    }
}

class LinkedList {
    private Node head;

    public void insert(int data) {
        Node newNode = new Node(data);
        newNode.next = head;
        head = newNode;
    }

    public void print() {
        Node temp = head;
        while (temp != null) {
            System.out.print(temp.data + " ");
            temp = temp.next;
        }
        System.out.println();
    }

    public static void main(String[] args) {
        LinkedList list = new LinkedList();
        list.insert(1);
        list.insert(2);
        list.insert(3);
        list.print();
    }
}
```
```python
class Node:
    def __init__(self, data):
        self.data = data
        self.next = None

class LinkedList:
    def __init__(self):
        self.head = None

    def insert(self, data):
        new_node = Node(data)
        new_node.next = self.head
        self.head = new_node

    def print_list(self):
        temp = self.head
        while temp:
            print(temp.data, end=" ")
            temp = temp.next
        print()

ll = LinkedList()
ll.insert(1)
ll.insert(2)
ll.insert(3)
ll.print_list()
```
```javascript
class Node {
    constructor(data) {
        this.data = data;
        this.next = null;
    }
}

class LinkedList {
    constructor() {
        this.head = null;
    }

    insert(data) {
        let newNode = new Node(data);
        newNode.next = this.head;
        this.head = newNode;
    }

    print() {
        let temp = this.head;
        while (temp !== null) {
            console.log(temp.data);
            temp = temp.next;
        }
    }
}

let list = new LinkedList();
list.insert(1);
list.insert(2);
list.insert(3);
list.print();
```

### Lista műveletek részletesen

#### Elem beszúrása (Insert)

Az insert művelet egy elem beszúrása a lista tetszőleges pozíciójába. Az alábbi példák bemutatják az insert művelet végrehajtását.

```cpp
#include <iostream>

struct Node {
    int data;
    Node* next;
    Node(int data) : data(data), next(nullptr) {}
};

class LinkedList {
public:
    LinkedList() : head(nullptr) {}

    void insert(int data) {
        Node* newNode = new Node(data);
        newNode->next = head;
        head = newNode;
    }

    void insertAt(int index, int data) {
        if (index == 0) {
            insert(data);
            return;
        }

        Node* temp = head;
        for (int i = 0; temp != nullptr && i < index - 1; i++) {
            temp = temp->next;
        }

        if (temp == nullptr) return;

        Node* newNode = new Node(data);
        newNode->next = temp->next;
        temp->next = newNode;
    }

    void print() {
        Node* temp = head;
        while (temp != nullptr) {
            std::cout << temp->data << " ";
            temp = temp->next;
        }
        std::cout << std::endl;
    }

private:
    Node* head;
};

int main() {
    LinkedList list;
    list.insert(1);
    list.insert(2);
    list.insertAt(1, 3);
    list.print();

    return 0;
}
```
```java
class Node {
    int data;
    Node next;

    Node(int data) {
        this.data = data;
        this.next = null;
    }
}

class LinkedList {
    private Node head;

    public void insert(int data) {
        Node newNode = new Node(data);
        newNode.next = head;
        head = newNode;
    }

    public void insertAt(int index, int data) {
        if (index == 0) {
            insert(data);
            return;
        }

        Node temp = head;
        for (int i = 0; temp != null && i < index - 1; i++) {
            temp = temp.next;
        }

        if (temp == null) return;

        Node newNode = new Node(data);
        newNode.next = temp.next;
        temp.next = newNode;
    }

    public void print() {
        Node temp = head;
        while (temp != null) {
            System.out.print(temp.data + " ");
            temp = temp.next;
        }
        System.out.println();
    }

    public static void main(String[] args) {
        LinkedList list = new LinkedList();
        list.insert(1);
        list.insert(2);
        list.insertAt(1, 3);
        list.print();
    }
}
```
```python
class Node:
    def __init__(self, data):
        self.data = data
        self.next = None

class LinkedList:
    def __init__(self):
        self.head = None

    def insert(self, data):
        new_node = Node(data)
        new_node.next = self.head
        self.head = new_node

    def insert_at(self, index, data):
        if index == 0:
            self.insert(data)
            return

        temp = self.head
        for i in range(index - 1):
            if temp is None:
                return
            temp = temp.next

        if temp is None:
            return

        new_node = Node(data)
        new_node.next = temp.next
        temp.next = new_node

    def print_list(self):
        temp = self.head
        while temp:
            print(temp.data, end=" ")
            temp = temp.next
        print()

ll = LinkedList()
ll.insert(1)
ll.insert(2)
ll.insert_at(1, 3)
ll.print_list()
```
```javascript
class Node {
    constructor(data) {
        this.data = data;
        this.next = null;
    }
}

class LinkedList {
    constructor() {
        this.head = null;
    }

    insert(data) {
        let newNode = new Node(data);
        newNode.next = this.head;
        this.head = newNode;
    }

    insertAt(index, data) {
        if (index === 0) {
            this.insert(data);
            return;
        }

        let temp = this.head;
        for (let i = 0; temp !== null && i < index - 1; i++) {
            temp = temp.next;
        }

        if (temp === null) return;

        let newNode = new Node(data);
        newNode.next = temp.next;
        temp.next = newNode;
    }

    print() {
        let temp = this.head;
        while (temp !== null) {
            console.log(temp.data);
            temp = temp.next;
        }
    }
}

let list = new LinkedList();
list.insert(1);
list.insert(2);
list.insertAt(1, 3);
list.print();
```

### Lista alkalmazások részletesen

#### Elem keresése (Search)

Az elem keresése a listában a lista bejárásával történik. Az alábbi példák bemutatják az elem keresésének végrehajtását.

```cpp
#include <iostream>

struct Node {
    int data;
    Node* next;
    Node(int data) : data(data), next(nullptr) {}
};

class LinkedList {
public:
    LinkedList() : head(nullptr) {}

    void insert(int data) {
        Node* newNode = new Node(data);
        newNode->next = head;
        head = newNode;
    }

    bool search(int key) {
        Node* temp = head;
        while (temp != nullptr) {
            if (temp->data == key) {
                return true;
            }
            temp = temp->next;
        }
        return false;
    }

    void print() {
        Node* temp = head;
        while (temp != nullptr) {
            std::cout << temp->data << " ";
            temp = temp->next;
        }
        std::cout << std::endl;
    }

private:
    Node* head;
};

int main() {
    LinkedList list;
    list.insert(1);
    list.insert(2);
    list.insert(3);
    list.print();

    int key = 2;
    if (list.search(key)) {
        std::cout << "Element " << key << " found in the list." << std::endl;
    } else {
        std::cout << "Element " << key << " not found in the list." << std::endl;
    }

    return 0;
}
```
```java
class Node {
    int data;
    Node next;

    Node(int data) {
        this.data = data;
        this.next = null;
    }
}

class LinkedList {
    private Node head;

    public void insert(int data) {
        Node newNode = new Node(data);
        newNode.next = head;
        head = newNode;
    }

    public boolean search(int key) {
        Node temp = head;
        while (temp != null) {
            if (temp.data == key) {
                return true;
            }
            temp = temp.next;
        }
        return false;
    }

    public void print() {
        Node temp = head;
        while (temp != null) {
            System.out.print(temp.data + " ");
            temp = temp.next;
        }
        System.out.println();
    }

    public static void main(String[] args) {
        LinkedList list = new LinkedList();
        list.insert(1);
        list.insert(2);
        list.insert(3);
        list.print();

        int key = 2;
        if (list.search(key)) {
            System.out.println("Element " + key + " found in the list.");
        } else {
            System.out.println("Element " + key + " not found in the list.");
        }
    }
}
```
```python
class Node:
    def __init__(self, data):
        self.data = data
        self.next = None

class LinkedList:
    def __init__(self):
        self.head = None

    def insert(self, data):
        new_node = Node(data)
        new_node.next = self.head
        self.head = new_node

    def search(self, key):
        temp = self.head
        while temp:
            if temp.data == key:
                return True
            temp = temp.next
        return False

    def print_list(self):
        temp = self.head
        while temp:
            print(temp.data, end=" ")
            temp = temp.next
        print()

ll = LinkedList()
ll.insert(1)
ll.insert(2)
ll.insert(3)
ll.print_list()

key = 2
if ll.search(key):
    print(f"Element {key} found in the list.")
else:
    print(f"Element {key} not found in the list.")
```
```javascript
class Node {
    constructor(data) {
        this.data = data;
        this.next = null;
    }
}

class LinkedList {
    constructor() {
        this.head = null;
    }

    insert(data) {
        let newNode = new Node(data);
        newNode.next = this.head;
        this.head = newNode;
    }

    search(key) {
        let temp = this.head;
        while (temp !== null) {
            if (temp.data === key) {
                return true;
            }
            temp = temp.next;
        }
        return false;
    }

    print() {
        let temp = this.head;
        while (temp !== null) {
            console.log(temp.data);
            temp = temp.next;
        }
    }
}

let list = new LinkedList();
list.insert(1);
list.insert(2);
list.insert(3);
list.print();

let key = 2;
if (list.search(key)) {
    console.log(`Element ${key} found in the list.`);
} else {
    console.log(`Element ${key} not found in the list.`);
}
```

## Összegzés

A lista alapvető adatszerkezet, amely számos fontos alkalmazással bír a számítástechnikában és a mindennapi életben. A fenti példák bemutatják, hogyan lehet listát létrehozni és használni különböző programozási nyelveken, valamint a lista gyakorlati alkalmazásait. A lista ismerete elengedhetetlen a programozási készségek fejlesztéséhez és a komplex algoritmusok megértéséhez.

## További források

- [GeeksforGeeks - Linked List Data Structure](https://www.geeksforgeeks.org/linked-list-data-structure/)
- [Wikipedia - Linked List](https://en.wikipedia.org/wiki/Linked_list)
