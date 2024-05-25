## Bevezetés

A gráfok ábrázolása az adatszerkezetek egy speciális területe, amely lehetővé teszi a csúcsok és élek közötti kapcsolatok hatékony kezelését. A gráfok ábrázolása különböző módokon történhet, és a megfelelő ábrázolás kiválasztása jelentősen befolyásolhatja az algoritmusok hatékonyságát és egyszerűségét. Ebben a leckében részletesen megvizsgáljuk a gráfok ábrázolásának elméleti alapjait és gyakorlati alkalmazásait különböző programozási nyelveken.

## Elméleti alapok

### Gráf definíciója

Egy gráf G(V, E) csúcsok V és élek E halmazából áll. A csúcsok a gráf csomópontjai, míg az élek a csúcsok közötti kapcsolatokat reprezentálják. A gráf lehet irányított (directed) vagy irányítatlan (undirected), attól függően, hogy az élek irányítottak-e vagy sem.

### Gráf reprezentációk típusai

1. **Szomszédsági mátrix (adjacency matrix)**:
    - Egy n x n-es mátrix, ahol n a csúcsok száma.
    - Az (i, j) eleme 1, ha van él az i és j csúcs között, különben 0.
    - Előnye: Egyszerű megvalósítás, gyors él keresés.
    - Hátránya: Nagy memóriaigényű, különösen ritka gráfok esetén.

2. **Szomszédsági lista (adjacency list)**:
    - Minden csúcshoz egy lista tartozik, amely tartalmazza az adott csúcshoz kapcsolódó csúcsokat.
    - Előnye: Memóriahatékony ritka gráfok esetén, könnyű csúcs szomszédok bejárása.
    - Hátránya: Lassabb él keresés, mint a szomszédsági mátrix esetén.

### Szomszédsági mátrix ábrázolás

```cpp
#include <iostream>
#include <vector>

class Graph {
private:
    std::vector<std::vector<int>> adjMatrix;
    int vertices;

public:
    Graph(int v) : vertices(v) {
        adjMatrix.resize(v, std::vector<int>(v, 0));
    }

    void addEdge(int src, int dest) {
        adjMatrix[src][dest] = 1;
        adjMatrix[dest][src] = 1; // Irányítatlan gráf esetén
    }

    void printGraph() {
        for (int i = 0; i < vertices; ++i) {
            for (int j = 0; j < vertices; ++j) {
                std::cout << adjMatrix[i][j] << " ";
            }
            std::cout << std::endl;
        }
    }
};

int main() {
    Graph g(5);
    g.addEdge(0, 1);
    g.addEdge(0, 4);
    g.addEdge(1, 2);
    g.addEdge(1, 3);
    g.addEdge(1, 4);
    g.addEdge(2, 3);
    g.addEdge(3, 4);

    g.printGraph();
    return 0;
}
```
```java
import java.util.Arrays;

class Graph {
    private int[][] adjMatrix;
    private int vertices;

    public Graph(int vertices) {
        this.vertices = vertices;
        adjMatrix = new int[vertices][vertices];
    }

    public void addEdge(int src, int dest) {
        adjMatrix[src][dest] = 1;
        adjMatrix[dest][src] = 1; // Irányítatlan gráf esetén
    }

    public void printGraph() {
        for (int[] row : adjMatrix) {
            System.out.println(Arrays.toString(row));
        }
    }

    public static void main(String[] args) {
        Graph g = new Graph(5);
        g.addEdge(0, 1);
        g.addEdge(0, 4);
        g.addEdge(1, 2);
        g.addEdge(1, 3);
        g.addEdge(1, 4);
        g.addEdge(2, 3);
        g.addEdge(3, 4);

        g.printGraph();
    }
}
```
```python
class Graph:
    def __init__(self, vertices):
        self.vertices = vertices
        self.adjMatrix = [[0] * vertices for _ in range(vertices)]

    def add_edge(self, src, dest):
        self.adjMatrix[src][dest] = 1
        self.adjMatrix[dest][src] = 1 # Irányítatlan gráf esetén

    def print_graph(self):
        for row in self.adjMatrix:
            print(' '.join(map(str, row)))

g = Graph(5)
g.add_edge(0, 1)
g.add_edge(0, 4)
g.add_edge(1, 2)
g.add_edge(1, 3)
g.add_edge(1, 4)
g.add_edge(2, 3)
g.add_edge(3, 4)

g.print_graph()
```
```javascript
class Graph {
    constructor(vertices) {
        this.vertices = vertices;
        this.adjMatrix = Array.from({ length: vertices }, () => Array(vertices).fill(0));
    }

    addEdge(src, dest) {
        this.adjMatrix[src][dest] = 1;
        this.adjMatrix[dest][src] = 1; // Irányítatlan gráf esetén
    }

    printGraph() {
        for (let row of this.adjMatrix) {
            console.log(row.join(' '));
        }
    }
}

const g = new Graph(5);
g.addEdge(0, 1);
g.addEdge(0, 4);
g.addEdge(1, 2);
g.addEdge(1, 3);
g.addEdge(1, 4);
g.addEdge(2, 3);
g.addEdge(3, 4);

g.printGraph();
```

### Szomszédsági lista ábrázolás

```cpp
#include <iostream>
#include <vector>
#include <list>

class Graph {
private:
    std::vector<std::list<int>> adjList;
    int vertices;

public:
    Graph(int v) : vertices(v) {
        adjList.resize(v);
    }

    void addEdge(int src, int dest) {
        adjList[src].push_back(dest);
        adjList[dest].push_back(src); // Irányítatlan gráf esetén
    }

    void printGraph() {
        for (int i = 0; i < vertices; ++i) {
            std::cout << i << ": ";
            for (int v : adjList[i]) {
                std::cout << v << " ";
            }
            std::cout << std::endl;
        }
    }
};

int main() {
    Graph g(5);
    g.addEdge(0, 1);
    g.addEdge(0, 4);
    g.addEdge(1, 2);
    g.addEdge(1, 3);
    g.addEdge(1, 4);
    g.addEdge(2, 3);
    g.addEdge(3, 4);

    g.printGraph();
    return 0;
}
```
```java
import java.util.LinkedList;

class Graph {
    private int vertices;
    private LinkedList<Integer> adjList[];

    public Graph(int vertices) {
        this.vertices = vertices;
        adjList = new LinkedList[vertices];
        for (int i = 0; i < vertices; ++i) {
            adjList[i] = new LinkedList();
        }
    }

    void addEdge(int src, int dest) {
        adjList[src].add(dest);
        adjList[dest].add(src); // Irányítatlan gráf esetén
    }

    void printGraph() {
        for (int i = 0; i < vertices; ++i) {
            System.out.print(i + ": ");
            for (Integer node : adjList[i]) {
                System.out.print(node + " ");
            }
            System.out.println();
        }
    }

    public static void main(String args[]) {
        Graph g = new Graph(5);
        g.addEdge(0, 1);
        g.addEdge(0, 4);
        g.addEdge(1, 2);
        g.addEdge(1, 3);
        g.addEdge(1, 4);
        g.addEdge(2, 3);
        g.addEdge(3, 4);

        g.printGraph();
    }
}
```
```python
class Graph:
    def __init__(self, vertices):
        self.vertices = vertices
        self.adjList = [[] for _ in range(vertices)]

    def add_edge(self, src, dest):
        self.adjList[src].append(dest)
        self.adjList[dest].append(src) # Irányítatlan gráf esetén

    def print_graph(self):
        for i in range(self.vertices):
            print(f"{i}: {' '.join(map(str, self.adjList[i]))}")

g = Graph(5)
g.add_edge(0, 1)
g.add_edge(0, 4)
g.add_edge(1, 2)
g.add_edge(1, 3)
g.add_edge(1, 4)
g.add_edge(2, 3)
g.add_edge(3, 4)

g.print_graph()
```
```javascript
class Graph {
    constructor(vertices) {
        this.vertices = vertices;
        this.adjList = new Array(vertices).fill(null).map(() => []);
    }

    addEdge(src, dest) {
        this.adjList[src].push(dest);
        this.adjList[dest].push(src); // Irányítatlan gráf esetén
    }

    printGraph() {
        for (let i = 0; i < this.vertices; ++i) {
            console.log(`${i}: ${this.adjList[i].join(' ')}`);
        }
    }
}

const g = new Graph(5);
g.addEdge(0, 1);
g.addEdge(0, 4);
g.addEdge(1, 2);
g.addEdge(1, 3);
g.addEdge(1, 4);
g.addEdge(2, 3);
g.addEdge(3, 4);

g.printGraph();
```

## Összegzés

A gráfok ábrázolásának megfelelő módja nagymértékben befolyásolja az algoritmusok hatékonyságát és egyszerűségét. A szomszédsági mátrix és szomszédsági lista különböző előnyökkel és hátrányokkal rendelkezik, és a választás attól függ, hogy milyen típusú gráfot és műveleteket kell kezelni. A fenti példák bemutatják, hogyan lehet gráfokat ábrázolni és kezelni különböző programozási nyelveken.

## További források

- [GeeksforGeeks - Graph Representation](https://www.geeksforgeeks.org/graph-representation/)
- [Wikipedia - Graph (abstract data type)](https://en.wikipedia.org/wiki/Graph_(abstract_data_type))
