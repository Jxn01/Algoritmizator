## Bevezetés

A szélességi keresés (angolul Breadth-First Search, BFS) egy fontos algoritmus, amelyet gráfok bejárására és keresésére használnak. A BFS-t széles körben alkalmazzák különböző problémák megoldására, például a legrövidebb út keresése, a kapcsolódó komponensek felismerése és a gráfok különböző tulajdonságainak feltárása során.

## Elméleti alapok

### Szélességi keresés definíciója

A szélességi keresés egy gráf bejárási algoritmus, amely a kiindulási csúcsból indul, és rétegenként halad előre. Először a kiindulási csúcs összes szomszédját látogatja meg, majd azok szomszédjait, és így tovább, amíg az összes csúcsot meg nem látogatta. A BFS általában soros adatszerkezetet (queue) használ a csúcsok következetes látogatására.

### Algoritmus lépései

1. Helyezzük a kiindulási csúcsot egy üres sorba, és jelöljük meg látogatottként.
2. Amíg a sor nem üres:
    - Vegyük ki a sor elején lévő csúcsot.
    - Látogassuk meg az összes szomszédját, amelyeket még nem látogattunk meg.
    - Helyezzük az összes meglátogatott, de még nem feldolgozott szomszédot a sor végére.
3. Ismételjük, amíg az összes csúcsot meg nem látogattuk.

### BFS tulajdonságai

- **Időbeli komplexitás**: O(V + E), ahol V a csúcsok száma, E pedig az élek száma.
- **Térbeli komplexitás**: O(V), a látogatott csúcsok nyilvántartásához és a sor tárolásához szükséges hely.

## Gyakorlati alkalmazások

### Legrövidebb út keresése

A BFS egyik legfontosabb alkalmazása a legrövidebb út keresése nem súlyozott gráfokban. Mivel a BFS rétegenként halad előre, garantálja, hogy az elsőként megtalált út a legrövidebb út lesz.

### Kapcsolódó komponensek felismerése

A BFS használható a gráf összes összefüggő komponensének felismerésére. Ha egy csúcsot még nem látogattunk meg, elindítunk egy BFS-t ebből a csúcsból, és az összes elérhető csúcsot megjelöljük, mint egy kapcsolódó komponens részét.

### BFS implementáció különböző programozási nyelveken

A következő kódpéldák bemutatják a szélességi keresés algoritmusának implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>
#include <queue>

class Graph {
public:
    Graph(int vertices) {
        this->vertices = vertices;
        adjList.resize(vertices);
    }

    void addEdge(int src, int dest) {
        adjList[src].push_back(dest);
    }

    void BFS(int start) {
        std::vector<bool> visited(vertices, false);
        std::queue<int> queue;
        visited[start] = true;
        queue.push(start);

        while (!queue.empty()) {
            int v = queue.front();
            std::cout << v << " ";
            queue.pop();

            for (int neighbor : adjList[v]) {
                if (!visited[neighbor]) {
                    visited[neighbor] = true;
                    queue.push(neighbor);
                }
            }
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

    std::cout << "Breadth First Traversal (starting from vertex 0): ";
    g.BFS(0);

    return 0;
}
```
```java
import java.util.*;

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
    }

    void BFS(int start) {
        boolean visited[] = new boolean[vertices];
        LinkedList<Integer> queue = new LinkedList<>();

        visited[start] = true;
        queue.add(start);

        while (queue.size() != 0) {
            start = queue.poll();
            System.out.print(start + " ");

            Iterator<Integer> i = adjList[start].listIterator();
            while (i.hasNext()) {
                int n = i.next();
                if (!visited[n]) {
                    visited[n] = true;
                    queue.add(n);
                }
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

        System.out.print("Breadth First Traversal (starting from vertex 0): ");
        g.BFS(0);
    }
}
```
```python
from collections import deque

class Graph:
    def __init__(self, vertices):
        self.vertices = vertices
        self.adjList = [[] for _ in range(vertices)]

    def add_edge(self, src, dest):
        self.adjList[src].append(dest)

    def BFS(self, start):
        visited = [False] * self.vertices
        queue = deque([start])
        visited[start] = True

        while queue:
            v = queue.popleft()
            print(v, end=" ")

            for neighbor in self.adjList[v]:
                if not visited[neighbor]:
                    visited[neighbor] = True
                    queue.append(neighbor)

g = Graph(5)
g.add_edge(0, 1)
g.add_edge(0, 4)
g.add_edge(1, 2)
g.add_edge(1, 3)
g.add_edge(1, 4)
g.add_edge(2, 3)
g.add_edge(3, 4)

print("Breadth First Traversal (starting from vertex 0): ", end="")
g.BFS(0)
```
```javascript
class Graph {
    constructor(vertices) {
        this.vertices = vertices;
        this.adjList = new Array(vertices).fill(null).map(() => []);
    }

    addEdge(src, dest) {
        this.adjList[src].push(dest);
    }

    BFS(start) {
        const visited = new Array(this.vertices).fill(false);
        const queue = [];
        visited[start] = true;
        queue.push(start);

        while (queue.length > 0) {
            const v = queue.shift();
            console.log(v);

            for (const neighbor of this.adjList[v]) {
                if (!visited[neighbor]) {
                    visited[neighbor] = true;
                    queue.push(neighbor);
                }
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

console.log("Breadth First Traversal (starting from vertex 0):");
g.BFS(0);
```

## Összegzés

A szélességi keresés egy hatékony algoritmus a gráfok bejárására és keresésére, amely számos gyakorlati alkalmazással rendelkezik. A fenti példák bemutatják a BFS implementációját különböző programozási nyelveken, valamint alkalmazási területeit, például a legrövidebb út keresését és a kapcsolódó komponensek felismerését. A BFS ismerete alapvető fontosságú a számítógéptudományban és az algoritmusok tanulmányozása során.

## További források

- [GeeksforGeeks - Breadth First Search or BFS for a Graph](https://www.geeksforgeeks.org/breadth-first-search-or-bfs-for-a-graph/)
- [Wikipedia - Breadth-first search](https://en.wikipedia.org/wiki/Breadth-first_search)
