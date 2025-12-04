    </main>

    <footer class="text-white text-center py-3" style="background-color: #212529; color: #f8f9fa; border-top: 1px solid #343a40;">
        <p>&copy; 2025 Isabela Moscatelli Nogueira. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
if (isset($link) && $link !== false) {
    mysqli_close($link);
}
?>