<?php
// admin/contacts.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

// Pagination & filtering
$page = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;
$filter = isset($_GET['filter']) && in_array($_GET['filter'], ['active','archived']) ? $_GET['filter'] : 'active';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Build query
$where = [];
if ($filter === 'active') $where[] = 'archived = 0';
if ($filter === 'archived') $where[] = 'archived = 1';
if ($search !== '') {
    $where[] = "(name LIKE :search OR email LIKE :search OR message LIKE :search)";
}
$where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Get total count
$count_query = "SELECT COUNT(*) FROM contacts $where_clause";
$stmt = $pdo->prepare($count_query);
if ($search !== '') $stmt->execute([':search'=>"%$search%"]);
else $stmt->execute();
$total = $stmt->fetchColumn();
$pages = ceil($total / $per_page);

// Get contacts for this page
$query = "SELECT id,name,email,message,archived,created_at FROM contacts $where_clause ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
if ($search !== '') $stmt->execute([':search'=>"%$search%"]);
else $stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Contacts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container my-5">
    <h1>Contact messages</h1>
    
    <div class="mb-3">
      <a href="/admin/export_contacts.php?filter=<?=htmlspecialchars($filter)?>" class="btn btn-sm btn-primary">Export CSV</a>
      <a href="/admin/" class="btn btn-secondary">Back</a>
    </div>

    <!-- Filter tabs -->
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item"><a class="nav-link <?= $filter === 'active' ? 'active' : '' ?>" href="?filter=active">Active (<?= $filter === 'active' ? $total : 'n/a' ?>)</a></li>
      <li class="nav-item"><a class="nav-link <?= $filter === 'archived' ? 'active' : '' ?>" href="?filter=archived">Archived (<?= $filter === 'archived' ? $total : 'n/a' ?>)</a></li>
    </ul>

    <!-- Search -->
    <form method="get" class="mb-3">
      <input type="hidden" name="filter" value="<?=htmlspecialchars($filter)?>">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search name, email, message..." value="<?=htmlspecialchars($search)?>">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
        <?php if ($search !== ''): ?><a href="?filter=<?=htmlspecialchars($filter)?>" class="btn btn-outline-secondary">Clear</a><?php endif; ?>
      </div>
    </form>

    <?php if (empty($contacts)): ?>
      <div class="alert alert-info">No messages found.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th><th>Actions</th></tr></thead>
          <tbody>
          <?php foreach($contacts as $c): ?>
            <tr>
              <td><?=htmlspecialchars($c['name'])?></td>
              <td><a href="mailto:<?=htmlspecialchars($c['email'])?>"><?=htmlspecialchars($c['email'])?></a></td>
              <td><small><?=nl2br(htmlspecialchars(substr($c['message'],0,100)))?><?= strlen($c['message']) > 100 ? '...' : '' ?></small></td>
              <td><small><?=htmlspecialchars($c['created_at'])?></small></td>
              <td>
                <form method="post" action="/admin/contacts_actions.php" style="display:inline;">
                  <input type="hidden" name="id" value="<?=$c['id']?>">
                  <input type="hidden" name="filter" value="<?=htmlspecialchars($filter)?>">
                  <?php if ($c['archived']): ?>
                    <button type="submit" name="action" value="unarchive" class="btn btn-xs btn-warning">Unarchive</button>
                  <?php else: ?>
                    <button type="submit" name="action" value="archive" class="btn btn-xs btn-warning">Archive</button>
                  <?php endif; ?>
                  <button type="submit" name="action" value="delete" class="btn btn-xs btn-danger" onclick="return confirm('Permanently delete this message?')">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if ($pages > 1): ?>
        <nav aria-label="Pagination">
          <ul class="pagination">
            <?php if ($page > 1): ?>
              <li class="page-item"><a class="page-link" href="?page=<?=$page-1?>&filter=<?=htmlspecialchars($filter)?>&search=<?=htmlspecialchars($search)?>">Previous</a></li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Previous</span></li>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $pages; $i++): ?>
              <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?=$i?>&filter=<?=htmlspecialchars($filter)?>&search=<?=htmlspecialchars($search)?>"><?=$i?></a>
              </li>
            <?php endfor; ?>
            
            <?php if ($page < $pages): ?>
              <li class="page-item"><a class="page-link" href="?page=<?=$page+1?>&filter=<?=htmlspecialchars($filter)?>&search=<?=htmlspecialchars($search)?>">Next</a></li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Next</span></li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  </body>
</html>
