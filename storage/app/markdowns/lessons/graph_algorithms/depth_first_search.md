## Bevezetés

A mélységi keresés (angolul Depth-First Search, DFS) egy fontos algoritmus, amelyet gráfok bejárására és keresésére használnak. A DFS-t széles körben alkalmazzák különböző problémák megoldására, például a komponensek felismerése, az útkeresés és a topológiai sorrend meghatározása során.

## Elméleti alapok

### Mélységi keresés definíciója

A mélységi keresés egy gráf bejárási algoritmus, amely a kiindulási csúcsból indul, és egy adott útvonal mentén halad tovább, amíg el nem éri az útvonal végét. Ezután visszalép és folytatja a keresést a következő útvonalon. A DFS általában verem adatszerkezetet (stack) használ, amely lehet rekurzív vagy iteratív megközelítésű.

### Algoritmus lépései

1. Kezdjük a kiindulási csúcsnál, és jelöljük meg látogatottként.
2. Látogassuk meg a kiindulási csúcs összes szomszédját rekurzív módon:
    - Ha egy szomszédot még nem látogattunk meg, akkor alkalmazzuk rá rekurzívan a DFS-t.
3. Ismételjük, amíg az összes csúcsot meg nem látogattuk.

### DFS tulajdonságai

- **Időbeli komplexitás**: O(V + E), ahol V a csúcsok száma, E pedig az élek száma.
- **Térbeli komplexitás**: O(V), a látogatott csúcsok nyilvántartásához és a rekurzió verem tárolásához szükséges hely.

## Gyakorlati alkalmazások

### Komponensek felismerése

A DFS segítségével könnyen felismerhetjük egy gráf összes összefüggő komponensét. Ha egy csúcsot még nem látogattunk meg, elindítunk egy DFS-t ebből a csúcsból, és az összes elérhető csúcsot megjelöljük, mint egy kapcsolódó komponens részét.

### Ciklusok felismerése

A DFS használható ciklusok felismerésére irányított és irányítatlan gráfokban egyaránt. Ha egy szomszédot újra elérünk, amely már látogatott, akkor egy ciklust találtunk.

### Topológiai sorrend meghatározása

A DFS használható topológiai sorrend meghatározására irányított aciklikus gráfokban (DAG). A DFS segítségével bejárjuk a gráfot, és a csúcsokat a bejárás sorrendjében egy verembe helyezzük. A verem kiürítése adja a topológiai sorrendet.

### DFS implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják a mélységi keresés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>

class Graph {
public:
    Graph(int vertices) {
        this->vertices = vertices;
        adjList.resize(vertices);
        visited.resize(vertices, false);
    }

    void addEdge(int src, int dest) {
        adjList[src].push_back(dest);
    }

    void DFS(int v) {
        visited[v] = true;
        std::cout << v << " ";

        for (int neighbor : adjList[v]) {
            if (!visited[neighbor]) {
                DFS(neighbor);
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
    }

    void DFS(int v) {
        visited[v] = true;
        System.out.print(v + " ");

        Iterator<Integer> i = adjList[v].listIterator();
        while (i.hasNext()) {
            int n = i.next();
            if (!visited[n]) {
                DFS(n);
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

A mélységi keresés egy hatékony algoritmus a gráfok bejárására és keresésére, amely számos gyakorlati alkalmazással rendelkezik. A fenti példák bemutatják a DFS implementációját különböző programozási nyelveken, valamint alkalmazási területeit, például a komponensek és ciklusok felismerését, illetve a topológiai sorrend meghatározását. A DFS ismerete alapvető fontosságú a számítógéptudományban és az algoritmusok tanulmányozása során.

## További források

- [GeeksforGeeks - Depth First Search or DFS for a Graph](https://www.geeksforgeeks.org/depth-first-search-or-dfs-for-a-graph/)
- [Wikipedia - Depth-first search](https://en.wikipedia.org/wiki/Depth-first_search)
