## Bevezetés

A legrövidebb út algoritmusok célja, hogy megtalálják a legkisebb költségű utat két csúcs között egy gráfban. Ezek az algoritmusok széles körben alkalmazhatók különböző területeken, például hálózattervezésben, útvonaltervezésben és kommunikációs hálózatokban. Ebben a leckében részletesen megvizsgáljuk a leggyakrabban használt legrövidebb út algoritmusokat, beleértve a Dijkstra algoritmust és a Bellman-Ford algoritmust, valamint azok gyakorlati alkalmazásait különböző programozási nyelveken.

## Elméleti alapok

### Gráfok és élek súlyozása

Egy súlyozott gráf olyan gráf, ahol minden élhez egy súly (vagy költség) van rendelve. Ezek a súlyok reprezentálhatják az utazási időt, távolságot, költséget vagy bármely más metrikát, amely a két csúcs közötti kapcsolatot jellemzi.

### Dijkstra algoritmus

A Dijkstra algoritmus egy hatékony módszer a legrövidebb út megtalálására egy adott kiindulási csúcs és a gráf többi csúcsa között. Az algoritmus nem működik negatív súlyú élek esetén.

### Bellman-Ford algoritmus

A Bellman-Ford algoritmus képes kezelni a negatív súlyú éleket, és megtalálja a legrövidebb utat egy adott kiindulási csúcs és a gráf többi csúcsa között. Ezenkívül felismeri a negatív súlyú köröket a gráfban.

## Dijkstra algoritmus implementáció

A következő kódpéldák bemutatják a Dijkstra algoritmus implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>
#include <queue>
#include <climits>

typedef std::pair<int, int> iPair;

class Graph {
    int V;
    std::vector<std::vector<iPair>> adj;

public:
    Graph(int V) {
        this->V = V;
        adj.resize(V);
    }

    void addEdge(int u, int v, int w) {
        adj[u].push_back({v, w});
        adj[v].push_back({u, w});
    }

    void dijkstra(int src) {
        std::priority_queue<iPair, std::vector<iPair>, std::greater<iPair>> pq;
        std::vector<int> dist(V, INT_MAX);
        pq.push({0, src});
        dist[src] = 0;

        while (!pq.empty()) {
            int u = pq.top().second;
            pq.pop();

            for (auto x : adj[u]) {
                int v = x.first;
                int weight = x.second;

                if (dist[v] > dist[u] + weight) {
                    dist[v] = dist[u] + weight;
                    pq.push({dist[v], v});
                }
            }
        }

        std::cout << "Vertex   Distance from Source\n";
        for (int i = 0; i < V; ++i)
            std::cout << i << "\t\t" << dist[i] << "\n";
    }
};

int main() {
    Graph g(9);
    g.addEdge(0, 1, 4);
    g.addEdge(0, 7, 8);
    g.addEdge(1, 2, 8);
    g.addEdge(1, 7, 11);
    g.addEdge(2, 3, 7);
    g.addEdge(2, 8, 2);
    g.addEdge(2, 5, 4);
    g.addEdge(3, 4, 9);
    g.addEdge(3, 5, 14);
    g.addEdge(4, 5, 10);
    g.addEdge(5, 6, 2);
    g.addEdge(6, 7, 1);
    g.addEdge(6, 8, 6);
    g.addEdge(7, 8, 7);

    g.dijkstra(0);

    return 0;
}
```
```java
import java.util.*;

class Graph {
    private int V;
    private LinkedList<Edge> adj[];

    class Edge {
        int v, weight;

        Edge(int v, int weight) {
            this.v = v;
            this.weight = weight;
        }
    }

    class Node implements Comparable<Node> {
        int vertex, dist;

        Node(int vertex, int dist) {
            this.vertex = vertex;
            this.dist = dist;
        }

        @Override
        public int compareTo(Node other) {
            return Integer.compare(this.dist, other.dist);
        }
    }

    Graph(int V) {
        this.V = V;
        adj = new LinkedList[V];
        for (int i = 0; i < V; ++i)
            adj[i] = new LinkedList<>();
    }

    void addEdge(int u, int v, int weight) {
        adj[u].add(new Edge(v, weight));
        adj[v].add(new Edge(u, weight));
    }

    void dijkstra(int src) {
        PriorityQueue<Node> pq = new PriorityQueue<>();
        int dist[] = new int[V];
        Arrays.fill(dist, Integer.MAX_VALUE);
        pq.add(new Node(src, 0));
        dist[src] = 0;

        while (!pq.isEmpty()) {
            Node node = pq.poll();
            int u = node.vertex;

            for (Edge edge : adj[u]) {
                int v = edge.v;
                int weight = edge.weight;

                if (dist[v] > dist[u] + weight) {
                    dist[v] = dist[u] + weight;
                    pq.add(new Node(v, dist[v]));
                }
            }
        }

        System.out.println("Vertex   Distance from Source");
        for (int i = 0; i < V; ++i)
            System.out.println(i + "\t\t" + dist[i]);
    }

    public static void main(String[] args) {
        Graph g = new Graph(9);
        g.addEdge(0, 1, 4);
        g.addEdge(0, 7, 8);
        g.addEdge(1, 2, 8);
        g.addEdge(1, 7, 11);
        g.addEdge(2, 3, 7);
        g.addEdge(2, 8, 2);
        g.addEdge(2, 5, 4);
        g.addEdge(3, 4, 9);
        g.addEdge(3, 5, 14);
        g.addEdge(4, 5, 10);
        g.addEdge(5, 6, 2);
        g.addEdge(6, 7, 1);
        g.addEdge(6, 8, 6);
        g.addEdge(7, 8, 7);

        g.dijkstra(0);
    }
}
```
```python
import heapq

class Graph:
    def __init__(self, vertices):
        self.V = vertices
        self.adj = [[] for _ in range(vertices)]

    def add_edge(self, u, v, weight):
        self.adj[u].append((v, weight))
        self.adj[v].append((u, weight))

    def dijkstra(self, src):
        dist = [float('inf')] * self.V
        dist[src] = 0
        pq = [(0, src)]

        while pq:
            current_dist, u = heapq.heappop(pq)

            if current_dist > dist[u]:
                continue

            for neighbor, weight in self.adj[u]:
                distance = current_dist + weight

                if distance < dist[neighbor]:
                    dist[neighbor] = distance
                    heapq.heappush(pq, (distance, neighbor))

        print("Vertex   Distance from Source")
        for i in range(self.V):
            print(f"{i}\t\t{dist[i]}")

g = Graph(9)
g.add_edge(0, 1, 4)
g.add_edge(0, 7, 8)
g.add_edge(1, 2, 8)
g.add_edge(1, 7, 11)
g.add_edge(2, 3, 7)
g.add_edge(2, 8, 2)
g.add_edge(2, 5, 4)
g.add_edge(3, 4, 9)
g.add_edge(3, 5, 14)
g.add_edge(4, 5, 10)
g.add_edge(5, 6, 2)
g.add_edge(6, 7, 1)
g.add_edge(6, 8, 6)
g.add_edge(7, 8, 7)

g.dijkstra(0)
```
```javascript
class Graph {
    constructor(vertices) {
        this.V = vertices;
        this.adj = new Array(vertices).fill(null).map(() => []);
    }

    addEdge(u, v, weight) {
        this.adj[u].push([v, weight]);
        this.adj[v].push([u, weight]);
    }

    dijkstra(src) {
        const dist = new Array(this.V).fill(Infinity);
        dist[src] = 0;
        const pq = new MinPriorityQueue({ priority: (x) => x[1] });
        pq.enqueue([src, 0]);

        while (!pq.isEmpty()) {
            const [u, current_dist] = pq.dequeue().element;

            if (current_dist > dist[u]) {
                continue;
            }

            for (const [neighbor, weight] of this.adj[u]) {
                const distance = current_dist + weight;

                if (distance < dist[neighbor]) {
                    dist[neighbor] = distance;
                    pq.enqueue([neighbor, distance]);
                }
            }
        }

        console.log("Vertex   Distance from Source");
        for (let i = 0; i < this.V; i++) {
            console.log(`${i}\t\t${dist[i]}`);
        }
    }
}

const g = new Graph(9);
g.addEdge(0, 1, 4);
g.addEdge(0, 7, 8);
g.addEdge(1, 2, 8);
g.addEdge(1, 7, 11);
g.addEdge(2, 3, 7);
g.addEdge(2, 8, 2);
g.addEdge(2, 5, 4);
g.addEdge(3, 4, 9);
g.addEdge(3, 5, 14);
g.addEdge(4, 5, 10);
g.addEdge(5, 6, 2);
g.addEdge(6, 7, 1);
g.addEdge(6, 8, 6);
g.addEdge(7, 8, 7);

g.dijkstra(0);
```

## Bellman-Ford algoritmus implementáció

A következő kódpéldák bemutatják a Bellman-Ford algoritmus implementációját különböző programozási nyelveken.

```cpp
#include <iostream>
#include <vector>
#include <climits>

class Graph {
    int V;
    std::vector<std::tuple<int, int, int>> edges;

public:
    Graph(int V) {
        this->V = V;
    }

    void addEdge(int u, int v, int w) {
        edges.push_back({u, v, w});
    }

    void bellmanFord(int src) {
        std::vector<int> dist(V, INT_MAX);
        dist[src] = 0;

        for (int i = 1; i <= V - 1; ++i) {
            for (auto [u, v, w] : edges) {
                if (dist[u] != INT_MAX && dist[u] + w < dist[v]) {
                    dist[v] = dist[u] + w;
                }
            }
        }

        for (auto [u, v, w] : edges) {
            if (dist[u] != INT_MAX && dist[u] + w < dist[v]) {
                std::cout << "Graph contains negative weight cycle\n";
                return;
            }
        }

        std::cout << "Vertex   Distance from Source\n";
        for (int i = 0; i < V; ++i)
            std::cout << i << "\t\t" << dist[i] << "\n";
    }
};

int main() {
    Graph g(5);
    g.addEdge(0, 1, -1);
    g.addEdge(0, 2, 4);
    g.addEdge(1, 2, 3);
    g.addEdge(1, 3, 2);
    g.addEdge(1, 4, 2);
    g.addEdge(3, 2, 5);
    g.addEdge(3, 1, 1);
    g.addEdge(4, 3, -3);

    g.bellmanFord(0);

    return 0;
}
```
```java
import java.util.*;

class Graph {
    private int V;
    private LinkedList<Edge> edges;

    class Edge {
        int src, dest, weight;

        Edge(int src, int dest, int weight) {
            this.src = src;
            this.dest = dest;
            this.weight = weight;
        }
    }

    Graph(int V) {
        this.V = V;
        edges = new LinkedList<>();
    }

    void addEdge(int src, int dest, int weight) {
        edges.add(new Edge(src, dest, weight));
    }

    void bellmanFord(int src) {
        int dist[] = new int[V];
        Arrays.fill(dist, Integer.MAX_VALUE);
        dist[src] = 0;

        for (int i = 1; i < V; ++i) {
            for (Edge edge : edges) {
                int u = edge.src;
                int v = edge.dest;
                int weight = edge.weight;
                if (dist[u] != Integer.MAX_VALUE && dist[u] + weight < dist[v]) {
                    dist[v] = dist[u] + weight;
                }
            }
        }

        for (Edge edge : edges) {
            int u = edge.src;
            int v = edge.dest;
            int weight = edge.weight;
            if (dist[u] != Integer.MAX_VALUE && dist[u] + weight < dist[v]) {
                System.out.println("Graph contains negative weight cycle");
                return;
            }
        }

        System.out.println("Vertex   Distance from Source");
        for (int i = 0; i < V; ++i)
            System.out.println(i + "\t\t" + dist[i]);
    }

    public static void main(String[] args) {
        Graph g = new Graph(5);
        g.addEdge(0, 1, -1);
        g.addEdge(0, 2, 4);
        g.addEdge(1, 2, 3);
        g.addEdge(1, 3, 2);
        g.addEdge(1, 4, 2);
        g.addEdge(3, 2, 5);
        g.addEdge(3, 1, 1);
        g.addEdge(4, 3, -3);

        g.bellmanFord(0);
    }
}
```
```python
class Graph:
    def __init__(self, vertices):
        self.V = vertices
        self.edges = []

    def add_edge(self, u, v, weight):
        self.edges.append((u, v, weight))

    def bellman_ford(self, src):
        dist = [float('inf')] * self.V
        dist[src] = 0

        for _ in range(self.V - 1):
            for u, v, weight in self.edges:
                if dist[u] != float('inf') and dist[u] + weight < dist[v]:
                    dist[v] = dist[u] + weight

        for u, v, weight in self.edges:
            if dist[u] != float('inf') and dist[u] + weight < dist[v]:
                print("Graph contains negative weight cycle")
                return

        print("Vertex   Distance from Source")
        for i in range(self.V):
            print(f"{i}\t\t{dist[i]}")

g = Graph(5)
g.add_edge(0, 1, -1)
g.add_edge(0, 2, 4)
g.add_edge(1, 2, 3)
g.add_edge(1, 3, 2)
g.add_edge(1, 4, 2)
g.add_edge(3, 2, 5)
g.add_edge(3, 1, 1)
g.add_edge(4, 3, -3)

g.bellman_ford(0)
```
```javascript
class Graph {
    constructor(vertices) {
        this.V = vertices;
        this.edges = [];
    }

    addEdge(u, v, weight) {
        this.edges.push([u, v, weight]);
    }

    bellmanFord(src) {
        const dist = new Array(this.V).fill(Infinity);
        dist[src] = 0;

        for (let i = 1; i < this.V; i++) {
            for (const [u, v, weight] of this.edges) {
                if (dist[u] !== Infinity && dist[u] + weight < dist[v]) {
                    dist[v] = dist[u] + weight;
                }
            }
        }

        for (const [u, v, weight] of this.edges) {
            if (dist[u] !== Infinity && dist[u] + weight < dist[v]) {
                console.log("Graph contains negative weight cycle");
                return;
            }
        }

        console.log("Vertex   Distance from Source");
        for (let i = 0; i < this.V; i++) {
            console.log(`${i}\t\t${dist[i]}`);
        }
    }
}

const g = new Graph(5);
g.addEdge(0, 1, -1);
g.addEdge(0, 2, 4);
g.addEdge(1, 2, 3);
g.addEdge(1, 3, 2);
g.addEdge(1, 4, 2);
g.addEdge(3, 2, 5);
g.addEdge(3, 1, 1);
g.addEdge(4, 3, -3);

g.bellmanFord(0);
```

## Összegzés

A legrövidebb út algoritmusok, mint a Dijkstra és a Bellman-Ford, alapvető fontosságúak a számítástechnikában és a különböző alkalmazásokban. A Dijkstra algoritmus hatékonyan működik nem negatív súlyú élek esetén, míg a Bellman-Ford algoritmus képes kezelni a negatív súlyú éleket is, és felismeri a negatív súlyú köröket. A fenti példák bemutatják e két algoritmus implementációját különböző programozási nyelveken, valamint gyakorlati alkalmazási területeiket.

## További források

- [GeeksforGeeks - Shortest Path Algorithms](https://www.geeksforgeeks.org/shortest-path-algorithms/)
- [Wikipedia - Dijkstra's algorithm](https://en.wikipedia.org/wiki/Dijkstra%27s_algorithm)
- [Wikipedia - Bellman-Ford algorithm](https://en.wikipedia.org/wiki/Bellman%E2%80%93Ford_algorithm)
