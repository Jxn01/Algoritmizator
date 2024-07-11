## Bevezetés

A gráf (angolul graph) egy olyan adatszerkezet, amely csúcsokból (vagy csomópontokból) és élekből áll, amelyek összekötik a csúcsokat. A gráfok széles körben használatosak a számítástechnikában és más tudományterületeken különböző problémák modellezésére, például hálózatok, útvonaltervezés és kapcsolatok ábrázolására.

## Elméleti alapok

### Gráf definíciója

Egy gráf G(V, E) csúcsok V és élek E halmazából áll. A csúcsok a gráf csomópontjai, míg az élek a csúcsok közötti kapcsolatokat reprezentálják. A gráf lehet irányított (directed) vagy irányítatlan (undirected), attól függően, hogy az élek irányítottak-e vagy sem.

### Gráf típusai

- **Irányítatlan gráf**: Az élek nem rendelkeznek iránnyal, tehát a kapcsolat mindkét irányban érvényes.
- **Irányított gráf (digráf)**: Az élek irányítottak, tehát a kapcsolat csak egy irányban érvényes.
- **Súlyozott gráf**: Az élekhez súlyok vannak rendelve, amelyek a kapcsolat költségét vagy hosszát reprezentálják.
- **Súlyozatlan gráf**: Az élekhez nincs rendelve súly.

### Gráf reprezentációk

- **Szomszédsági mátrix (adjacency matrix)**: Egy n x n-es mátrix, ahol n a csúcsok száma, és az (i, j) eleme 1, ha van él az i és j csúcs között, különben 0.
- **Szomszédsági lista (adjacency list)**: Minden csúcshoz egy lista tartozik, amely tartalmazza az adott csúcshoz kapcsolódó csúcsokat.

### Absztrakt adattípus (ADT) gráf

A gráf absztrakt adattípus (ADT), amely a következő műveleteket támogatja:

- **AddVertex (Csúcs hozzáadása)**: Új csúcs hozzáadása a gráfhoz.
- **AddEdge (Él hozzáadása)**: Új él hozzáadása a gráfhoz.
- **RemoveVertex (Csúcs eltávolítása)**: Egy csúcs eltávolítása a gráfból.
- **RemoveEdge (Él eltávolítása)**: Egy él eltávolítása a gráfból.
- **Search (Keresés)**: Egy csúcs vagy él keresése a gráfban.
- **Traverse (Bejárás)**: A gráf bejárása különböző algoritmusokkal (pl. DFS, BFS).

## Gráf gyakorlati alkalmazásai

### Egyszerű gráf létrehozása és kezelése

A következő kódpéldák bemutatják, hogyan lehet létrehozni és kezelni egy egyszerű gráfot különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>

class Graph {
public:
    Graph(int vertices) {
        adjList.resize(vertices);
        this->vertices = vertices;
    }

    void addEdge(int src, int dest) {
        adjList[src].push_back(dest);
        adjList[dest].push_back(src); // Irányítatlan gráf esetén
    }

    void printGraph() {
        for (int i = 0; i < vertices; ++i) {
            std::cout << i << ": ";
            for (int j : adjList[i]) {
                std::cout << j << " ";
            }
            std::cout << std::endl;
        }
    }

private:
    int vertices;
    std::vector<std::vector<int>> adjList;
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

### Gráf bejárása (Traversal)

A gráf bejárása a csúcsok meglátogatását jelenti különböző algoritmusokkal. Az alábbi példák bemutatják a mélységi keresés (DFS) algoritmus végrehajtását különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>

class Graph {
public:
    Graph(int vertices) {
        adjList.resize(vertices);
        this->vertices = vertices;
        visited.resize(vertices, false);
    }

    void addEdge(int src, int dest) {
        adjList[src].push_back(dest);
        adjList[dest].push_back(src); // Irányítatlan gráf esetén
    }

    void DFS(int v) {
        visited[v] = true;
        std::cout << v << " ";
        for (int i : adjList[v]) {
            if (!visited[i]) {
                DFS(i);
            }
        }
    }

private:
    int vertices;
    std::vector<std::vector<int>> adjList;
    std::vector<bool> visited;
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

    std::cout << "Depth First Traversal (starting from vertex 0): ";
    g.DFS(0);
    return 0;
}
```
```java
import java.util.*;

class Graph {
    private int vertices;
    private LinkedList<Integer> adjList[];
    private boolean visited[];

    public Graph(int vertices) {
        this.vertices = vertices;
        adjList = new LinkedList[vertices];
        visited = new boolean[vertices];
        for (int i = 0; i < vertices; ++i) {
            adjList[i] = new LinkedList();
        }
    }

    void addEdge(int src, int dest) {
        adjList[src].add(dest);
        adjList[dest].add(src); // Irányítatlan gráf esetén
    }

    void DFS(int v) {
        visited[v] = true;
        System.out.print(v + " ");
        for (Integer node : adjList[v]) {
            if (!visited[node]) {
                DFS(node);
            }
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

        System.out.print("Depth First Traversal (starting from vertex 0): ");
        g.DFS(0);
    }
}
```
```python
class Graph:
    def __init__(self, vertices):
        self.vertices = vertices
        self.adjList = [[] for _ in range(vertices)]
        self.visited = [False] * vertices

    def add_edge(self, src, dest):
        self.adjList[src].append(dest)
        self.adjList[dest].append(src) # Irányítatlan gráf esetén

    def DFS(self, v):
        self.visited[v] = True
        print(v, end=" ")
        for neighbor in self.adjList[v]:
            if not self.visited[neighbor]:
                self.DFS(neighbor)

g = Graph(5)
g.add_edge(0, 1)
g.add_edge(0, 4)
g.add_edge(1, 2)
g.add_edge(1, 3)
g.add_edge(1, 4)
g.add_edge(2, 3)
g.add_edge(3, 4)

print("Depth First Traversal (starting from vertex 0): ", end="")
g.DFS(0)
```
```javascript
class Graph {
    constructor(vertices) {
        this.vertices = vertices;
        this.adjList = new Array(vertices).fill(null).map(() => []);
        this.visited = new Array(vertices).fill(false);
    }

    addEdge(src, dest) {
        this.adjList[src].push(dest);
        this.adjList[dest].push(src); // Irányítatlan gráf esetén
    }

    DFS(v) {
        this.visited[v] = true;
        console.log(v);
        for (const neighbor of this.adjList[v]) {
            if (!this.visited[neighbor]) {
                this.DFS(neighbor);
            }
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

console.log("Depth First Traversal (starting from vertex 0):");
g.DFS(0);
```

## Összegzés

A gráf egy rendkívül sokoldalú adatszerkezet, amely számos fontos alkalmazással bír a számítástechnikában és a hálózati problémák megoldásában. A fenti példák bemutatják, hogyan lehet gráfot létrehozni és használni különböző programozási nyelveken, valamint a gráf gyakorlati alkalmazásait, például a mélységi keresést. A gráf ismerete elengedhetetlen a programozási készségek fejlesztéséhez és a komplex algoritmusok megértéséhez.

## További források

- [GeeksforGeeks - Graph Data Structure](https://www.geeksforgeeks.org/graph-data-structure-and-algorithms/)
- [Wikipedia - Graph (abstract data type)](https://en.wikipedia.org/wiki/Graph_(abstract_data_type))
