<?= $this->extend('templates/index') ?>
<?= $this->section('page-content') ?>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">User List</h1>
                    
                <table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">username</th>
      <th scope="col">email</th>
      <th scope="col">role</th>
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach ($users as $user): ?>
    <tr>
      <th scope="row"><?= $i++; ?></th>
      <td><?= esc($user->username); ?></td>
      <td><?= esc($user->email); ?></td>
      <td><?= esc($user->role); ?></td>
      <td>
<a href="<?= base_url('admin/detail/' . $user->userid); ?>" class="btn btn-sm btn-info">Detail</a>



      </td>
    </tr>
    <?php endforeach; ?>
</tbody>

</table>
                </div>
                </div>
                <?= $this->endSection() ?>