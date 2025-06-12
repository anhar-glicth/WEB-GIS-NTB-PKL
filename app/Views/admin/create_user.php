<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>
<form action="<?= base_url('admin/saveUser'); ?>" method="post" style="margin-left: 20px;">

    <?= csrf_field(); ?>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="user">User</option>
            <option value="petugas">Petugas</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Tambah User</button>
</form>
<?= $this->endSection() ?>