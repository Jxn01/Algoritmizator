## Bevezetés

A verem (angolul stack) egy olyan adatszerkezet, amelyben az elemeket LIFO (Last In, First Out) elv szerint kezeljük. Ez azt jelenti, hogy az utoljára beillesztett elem lesz az első, amit eltávolítunk. A verem használata elengedhetetlen számos algoritmus és adatszerkezet megvalósításában. Ebben a leckében részletesen megvizsgáljuk a verem elméleti alapjait és gyakorlati alkalmazásait különböző programozási nyelveken.

## Elméleti alapok

### Verem definíciója

A verem egy olyan adatszerkezet, amely támogatja az elemek beszúrását (push) és eltávolítását (pop) egy végéről, az úgynevezett verem tetejéről. A verem csak a tetején lévő elemet teszi elérhetővé, így a legutóbb beszúrt elem lesz az első, amit eltávolítunk.

### Verem memóriakezelése

A verem memóriakezelése egyszerű, mivel csak a verem tetejét kell nyilvántartani. Az elemek hozzáadása és eltávolítása O(1) időben történik, ami nagyon hatékony memória- és időfelhasználást biztosít.

### Absztrakt adattípus (ADT) verem

A verem absztrakt adattípus (ADT), amely a következő műveleteket támogatja:

- **Push (Beszúrás)**: Új elem hozzáadása a verem tetejére.
- **Pop (Eltávolítás)**: A verem tetején lévő elem eltávolítása.
- **Peek (Megtekintés)**: A verem tetején lévő elem megtekintése eltávolítás nélkül.
- **IsEmpty (Üresség ellenőrzés)**: Annak ellenőrzése, hogy a verem üres-e.

### Verem alkalmazásai

- **Függvényhívások kezelése**: A függvényhívások és visszatérések verem segítségével történnek, amelyet hívási veremnek nevezünk.
- **Visszalépési algoritmusok**: A backtracking algoritmusok, például a mélységi keresés (DFS), vermet használnak a visszalépési pontok kezelésére.
- **Fordítók**: A fordítók a szintaktikai elemzés során vermet használnak a zárójelek párosítására és az aritmetikai kifejezések értékelésére.

## Verem gyakorlati alkalmazásai

### Verem létrehozása és kezelése

A következő kódpéldák bemutatják, hogyan lehet létrehozni és kezelni egy vermet különböző programozási nyelveken.

```cpp
#include <iostream>
#include <stack>

int main() {
    std::stack<int> s;
    s.push(1);
    s.push(2);
    s.push(3);

    while (!s.empty()) {
        std::cout << s.top() << " ";
        s.pop();
    }

    return 0;
}
```
```java
import java.util.Stack;

public class Main {
    public static void main(String[] args) {
        Stack<Integer> s = new Stack<>();
        s.push(1);
        s.push(2);
        s.push(3);

        while (!s.isEmpty()) {
            System.out.print(s.pop() + " ");
        }
    }
}
```
```python
stack = []
stack.append(1)
stack.append(2)
stack.append(3)

while stack:
    print(stack.pop(), end=" ")
```
```javascript
let stack = [];
stack.push(1);
stack.push(2);
stack.push(3);

while (stack.length > 0) {
    console.log(stack.pop());
}
```

### Verem műveletek részletesen

#### Push művelet

A push művelet egy elem hozzáadása a verem tetejére. Az alábbi példákban bemutatjuk a push művelet végrehajtását.

```cpp
#include <iostream>
#include <stack>

int main() {
    std::stack<int> s;
    s.push(10);
    std::cout << "Pushed 10" << std::endl;
    return 0;
}
```
```java
import java.util.Stack;

public class Main {
    public static void main(String[] args) {
        Stack<Integer> s = new Stack<>();
        s.push(10);
        System.out.println("Pushed 10");
    }
}
```
```python
stack = []
stack.append(10)
print("Pushed 10")
```
```javascript
let stack = [];
stack.push(10);
console.log("Pushed 10");
```

#### Pop művelet

A pop művelet eltávolítja a verem tetején lévő elemet. Az alábbi példákban bemutatjuk a pop művelet végrehajtását.

```cpp
#include <iostream>
#include <stack>

int main() {
    std::stack<int> s;
    s.push(10);
    s.push(20);
    s.pop();
    std::cout << "Popped top element" << std::endl;
    return 0;
}
```
```java
import java.util.Stack;

public class Main {
    public static void main(String[] args) {
        Stack<Integer> s = new Stack<>();
        s.push(10);
        s.push(20);
        s.pop();
        System.out.println("Popped top element");
    }
}
```
```python
stack = []
stack.append(10)
stack.append(20)
stack.pop()
print("Popped top element")
```
```javascript
let stack = [];
stack.push(10);
stack.push(20);
stack.pop();
console.log("Popped top element");
```

### Verem alkalmazások részletesen

#### Szintaktikai elemzés

A fordítók és értelmezők szintaktikai elemzése során vermet használnak a zárójelek és kifejezések helyes párosításának ellenőrzésére.

```cpp
#include <iostream>
#include <stack>
#include <string>

bool isBalanced(const std::string& expr) {
    std::stack<char> s;
    for (char c : expr) {
        if (c == '(') {
            s.push(c);
        } else if (c == ')') {
            if (s.empty()) return false;
            s.pop();
        }
    }
    return s.empty();
}

int main() {
    std::string expr = "(a+b)*(c+d)";
    std::cout << (isBalanced(expr) ? "Balanced" : "Not Balanced") << std::endl;
    return 0;
}
```
```java
import java.util.Stack;

public class Main {
    public static boolean isBalanced(String expr) {
        Stack<Character> s = new Stack<>();
        for (char c : expr.toCharArray()) {
            if (c == '(') {
                s.push(c);
            } else if (c == ')') {
                if (s.isEmpty()) return false;
                s.pop();
            }
        }
        return s.isEmpty();
    }

    public static void main(String[] args) {
        String expr = "(a+b)*(c+d)";
        System.out.println(isBalanced(expr) ? "Balanced" : "Not Balanced");
    }
}
```
```python
def is_balanced(expr):
    stack = []
    for char in expr:
        if char == '(':
            stack.append(char)
        elif char == ')':
            if not stack:
                return False
            stack.pop()
    return not stack

expr = "(a+b)*(c+d)"
print("Balanced" if is_balanced(expr) else "Not Balanced")
```
```javascript
function isBalanced(expr) {
    let stack = [];
    for (let char of expr) {
        if (char === '(') {
            stack.push(char);
        } else if (char === ')') {
            if (stack.length === 0) return false;
            stack.pop();
        }
    }
    return stack.length === 0;
}

let expr = "(a+b)*(c+d)";
console.log(isBalanced(expr) ? "Balanced" : "Not Balanced");
```

## Összegzés

A verem alapvető adatszerkezet, amely számos fontos alkalmazással bír a számítástechnikában. A fenti példák bemutatják, hogyan lehet vermet létrehozni és használni különböző programozási nyelveken, valamint a verem gyakorlati alkalmazásait. A verem ismerete elengedhetetlen a programozási készségek fejlesztéséhez és a komplex algoritmusok megértéséhez.

## További források

- [GeeksforGeeks - Stack Data Structure](https://www.geeksforgeeks.org/stack-data-structure/)
- [Wikipedia - Stack (abstract data type)](https://en.wikipedia.org/wiki/Stack_(abstract_data_type))
